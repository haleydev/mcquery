<?php
namespace Core\Template;
use Throwable;

class Template
{ 
    private $template;
    private array $params;

    /**
     * Renderiza um template.
     * @param string $template ('views/example')
     * @param array|object $params Parâmetros a serem enviados para o template.
     * @return template
     */
    public function template(string $template, array|object $params = [])
    {
        $file = ROOT . '/templates/' . $template . '.php';  
        $cache = ROOT .  '/app/Cache/template/' .$template . '.php';
       
        if (file_exists($file)) {            
            if(!file_exists($cache) or $this->check_cache($file)){
                (new TemplateCompiler)->compiler($file);
            }
            
            if(is_object($params)){
                $this->params = get_object_vars($params);
            }else{
                $this->params = $params;
            }
            
            $this->template = $cache;

            return $this->render();
        }                 
        
        die('Arquivo não encontrado ' . $file);         
    }  

    private function check_cache($file)
    { 
        $olf_file = ROOT . '/app/Cache/old_template.json';
        if(!file_exists($olf_file)){
            return true;
        }
       
        $old_cache = json_decode(file_get_contents($olf_file),true);
        if(isset($old_cache[$file])){
            // verificar se o arquivo principal foi alterado
            if($old_cache[$file]['time'] == filectime($file)){
                $main = true;
            }else{
                $main = false;
            }

            // verificar se os arquivos necessarios foram alterados
            $requires = true;
            if($old_cache[$file]['requires'] != false){ 
                foreach($old_cache[$file]['requires'] as $require => $time) {
                    if($time != filectime($require)){
                        $requires = false;                        
                    }
                }               
            }
            
            if ($main and $requires) {
                return false;
            }            
        }   
        
        return true;
    }

    private function render()
    {   
        $params = $this->params;

        try {    
            if(count($params) == 0){
                return require_once $this->template; 
            }else{
                foreach($params as $key => $value) { $$key = $value; }
                return require_once $this->template;
            }                
        } catch (Throwable $error) {
            echo "Error: " . $error->getMessage() . "<br>";  
        }
    }

}
