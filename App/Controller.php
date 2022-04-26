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
        if (isset($this->view) and $view == null) {
            $view = $this->view;
        }

        $fileview = dirname(__DIR__)."/./Templates/views/$view.php";
        if (file_exists($fileview)) {
            require $fileview;
        } else {
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
        if (isset($this->layout) and $layout == null) {
            $layout = $this->layout;
        }
        if (file_exists(dirname(__DIR__)."/./Templates/layouts/$layout.php")) {
            require dirname(__DIR__)."/./Templates/layouts/$layout.php";
            return $this;
        } else {
            echo "layout não encontrado";
            return;
        }

        return $this;
    }

    /**
     * Retorna um include contido em Templates/includes.  
     * @return string|require         
     */
    public function includer(string $include  = null)
    {
        if (isset($this->include) and $include == null) {
            $include = $this->include;
        }

        if (file_exists(dirname(__DIR__)."/./Templates/includes/$include.php")) {
            require dirname(__DIR__)."/./Templates/includes/$include.php";
        } else {
            echo "include não encontrado";
            return;
        }

        return $this;
    }    
}