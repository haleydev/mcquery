<?php
namespace Core\Template;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TemplateCompiler
{ 
    private $template;
    private array $get_set = [];
    private array|bool $requires = [];   
    
    public function compiler($template_local)
    {            
        $dir = ROOT . '/templates/';
        $directory_iterator = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directory_iterator,RecursiveIteratorIterator::CHILD_FIRST);
     
        $dir_template = ROOT . '/app/Cache/template';
        if (!file_exists($dir_template)) {
            mkdir($dir_template);
        }

        foreach($files as $file){ 
            if($file->isFile()) {
                $old_file = str_replace(ROOT.'/templates','',$file->getPathname());
                $template = str_replace(ROOT.'/templates','',$template_local);

                if(str_replace('\\','/',$old_file) == str_replace('\\','/',$template) and is_file($template_local)){
                    $folders = explode('/',trim(str_replace('\\','/',$template),'/'));  
                    $new_file = $folders[count($folders) - 1];  

                    $count = 0;  
                    foreach($folders as $sub_dir){
                        if ($sub_dir != $new_file) {
                            $dir_template .= '/' . $sub_dir;                        
                            if (!file_exists($dir_template)) {
                                mkdir($dir_template);
                            }
                        }                   
    
                        $count++;
                    }

                    $this->template = file_get_contents($template_local);                
                    $this->reader();
                    file_put_contents($dir_template . '/' . $new_file, $this->template);

                    if(count($this->requires) == 0) {            
                        $this->requires = false;              
                    }
            
                    $old_template = ROOT . '/app/Cache/templates.json';
            
                    if(file_exists($old_template)){           
                        $old_cache = json_decode(file_get_contents($old_template),true);
                        $old_cache[$template_local]['requires'] = $this->requires;
                        $old_cache[$template_local]['time'] = filemtime($template_local);                       
                        file_put_contents($old_template, json_encode($old_cache,true));
                    }else{
                        $new_cache[$template_local]['time'] = filemtime($template_local);
                        $new_cache[$template_local]['requires'] = $this->requires;
                        file_put_contents($old_template, json_encode($new_cache,true));            
                    }
                         
                    return;
                }
            }                
        }         

        die;
    }  
    
    private function reader()
    {     
        //https://www.phpliveregex.com/#tab-preg-match-all

        //alternativa mat
        //https://www.w3schools.com/php/phptryit.asp?filename=tryphp_func_regex_preg_replace_callback_array

        $render = true;

        // start templates
        $view = "/@view\((.*?)\)/s";    
        if (preg_match_all($view, $this->template, $matches)) {
            $render = false;   
            return $this->view($matches); 
        }     
        
        $include = "/@include\((.*?)\)/s";    
        if (preg_match_all($include, $this->template, $matches)) { 
            $render = false;
            return $this->include($matches);            
        }   

        $layout = "/@layout\((.*?)\)/s";    
        if (preg_match_all($layout, $this->template, $matches)) {              
            $render = false;   
            return $this->layout($matches);            
        }   
        // end templates

        $get = "/@get\((.*?)\)/s";    
        if (preg_match_all($get, $this->template, $matches)) {    
            $render = false;  
            return $this->get_set($matches); 
        }   

        $set = "/@set\((.*?)\)/s";    
        if (preg_match_all($set, $this->template, $matches)) {               
            die('Error: ' . $matches[0][0] . ' não possui um @get(' . $matches[1][0] . ').');           
        }   
                
        if($render) {
            $this->template = trim($this->template);  
            return true;          
        }        
    }

    private function view($matches)
    {        
        foreach($matches[1] as $key => $value) {
            $file = ROOT . '/templates/views/' . $value . '.php';
            if (file_exists($file)) {                
                $this->requires[$file] = filemtime($file);
                $view = file_get_contents($file);
                $replace = str_replace($matches[0][$key], $view, $this->template);
                $this->template = $replace;                
            }else{
                die('Arquivo não encontrado ' . $file);
            }            
        }

        $this->reader();               
        return;
    }

    private function layout($matches)
    {        
        foreach($matches[1] as $key => $value) {
            $file = ROOT . '/templates/layouts/' . $value . '.php';
            if (file_exists($file)) {
                $this->requires[$file] = filemtime($file);
                $layout = file_get_contents($file);
                $replace = str_replace($matches[0][$key], $layout, $this->template);
                $this->template = $replace;                
            }else{
                die('Arquivo não encontrado ' . $file);
            }            
        }
        
        $this->reader();       
        return;
    }

    private function include($matches)
    {        
        foreach($matches[1] as $key => $value) {
            $file = ROOT . '/templates/includes/' . $value . '.php';
            if (file_exists($file)) {
                $this->requires[$file] = filemtime($file);
                $include = file_get_contents($file);
                $replace = str_replace($matches[0][$key], $include, $this->template);
                $this->template = $replace;                
            }else{
                die('Arquivo não encontrado ' . $file);
            }            
        }
        
        $this->reader();       
        return;
    }

    private function get_set($matches)
    {         
        foreach($matches[1] as $key => $value) { 
            $section = "/@set\($value\)(.*?)@end\($value\)/s";  
            if (preg_match_all($section, $this->template, $matches_set)) { 

                foreach($matches_set[0] as $set_key => $set_value){  
                    $this->get_set[$value] = [$matches[0][$key],$set_value,$matches_set[1][$set_key]];                    
                }

            }else{
                $section = "/@set\($value\)->\((.*?)\)/s";  
                if (preg_match_all($section, $this->template, $matches_set)) {
    
                    foreach($matches_set[0] as $set_key => $set_value){
                        if(substr($matches_set[1][$set_key], 0, 1) == '$'){
                            $set_mini = '<?php echo '. $matches_set[1][$set_key] .' ?>';                        
                        }else{
                            $set_mini = $matches_set[1][$set_key];
                        }

                        $this->get_set[$value] = [$matches[0][$key],$set_value,$set_mini];                    
                    }
    
                }else{
                    $this->get_set[$value] = [$matches[0][$key],'',''];
                }               
            }
        }

        foreach($this->get_set as $key => $value) {
            $replace = str_replace($value[1],'', $this->template);
            $replace = str_replace($value[0], $value[2], $replace);
            $this->template = $replace;     
        }

        $this->reader();              
        return;        
    }
}
