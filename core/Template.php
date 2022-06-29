<?php
namespace Core;
use Throwable;

class Template
{ 
    private $template;
    private array $get_set = [];
    private array $params;
    private string $file_local;
    private bool $cache = false;

    //test
    private string $file_root;

    public function template(string $template, array|object $params = [])
    {
        $file = ROOT . '/templates/' . $template . '.php';
        $this->file_root = $file;
        $this->file_local = $template;        

        dd(filemtime($this->file_root));

        if (file_exists($file)) {

            if(is_object($params)){
                $this->params = get_object_vars($params);
            }else{
                $this->params = $params; 
            }
            
            $file_chache = ROOT . '/app/Cache/template/' . $template . '.php';
            if(file_exists($file_chache)){
                // if(filemtime(ROOT . '/templates/') != )
            }

            $this->template = file_get_contents($file);             
            return $this->reader();         
        }else{
            die('Arquivo não encontrado ' . $file);
        } 
    }  
    
    private function cache()
    {          
        // if(!file_exists(ROOT.'/app/Cache/template/file.php')){
        //     file_put_contents(ROOT.'/app/Cache/template/file.php', $this->template, LOCK_EX); 
        // }  
       
        file_put_contents(ROOT.'/app/Cache/template/' .$this->file_local . '_'.filemtime($this->file_root).'.php', $this->template); 
    }

    private function cache_checker()
    {
        $file = '';
    }
    
    private function reader()
    {     
        //https://www.phpliveregex.com/#tab-preg-match-all

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
            return $this->render();
        }        
    }

    private function view($matches)
    {        
        foreach($matches[1] as $key => $value) {
            $file = ROOT . '/templates/views/' . $value . '.php';
            if (file_exists($file)) {
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
                        if(str_contains($matches_set[1][$set_key],'$')){
                            $variable_key = str_replace('$','',$matches_set[1][$set_key]);
                            if(isset($this->params[$variable_key])){
                                $set_mini = $this->params[$variable_key];
                            }else{
                                $set_mini = 'Variável '. $matches_set[1][$set_key] .' não definida';
                            }                            
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

    private function render()
    {    
        $this->cache();  
        $params = $this->params;
        try {           
            return eval('foreach($params as $key => $value) { $$key = $value; } ;?>' . $this->template);        
        } catch (Throwable $error) {
            echo "Error: " . $error->getMessage() . "<br>";  
        }
    }
}
