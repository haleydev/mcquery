<?php
namespace App;

/**
 * Gerenciador de funções dos controllers.
 */  

class Controller
{   
    /**
     * Retorna uma view contida em Templates/views.
     * @return string|require   
     */    
    public function view(string $view = null)
    { 
        if(isset($this->view) and $view == null){
            $view = $this->view;
        }

        $fileview = "Templates/views/$view.php";
        if(file_exists($fileview)){
            require $fileview;
        }else{
            echo "view não encontrada";
        } 
        
        return $this;        
    }
 
    /**
     * Retorna um layout contido em Templates/layouts.  
     * @return string|require         
     */
    public function layout(string $layout = null)
    {  
        if(isset($this->layout) and $layout == null){
            $layout = $this->layout;
        }
        if(file_exists("Templates/layouts/$layout.php")){
            require "Templates/layouts/$layout.php";
            return $this;
        }else{
            echo "layout não encontrado";
            return;
        }

        return $this;
    }

    /**
     * Retorna um include contido em Templates/includes.  
     * @return string|require         
     */   
    public function include(string $include  = null)
    {  
        if(isset($this->include) and $include == null){
            $include = $this->include;
        }

        if(file_exists("Templates/includes/$include.php")){
            require "Templates/includes/$include.php";
        }else{
            echo "include não encontrado";
            return;
        }

        return $this;
    }
}