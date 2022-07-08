<?php
namespace Core\Router;
use Controllers\ErrorController;

class RouteAction
{ 
    public function __construct($action)
    {
        if(is_string($action)){
            return $this->string( ROOT.$action);
        }  
        
        if(is_array($action)){
            return $this->array($action);
        }

        if(is_callable($action)){
            return $this->callable($action);
        }         
    }

    private function string(string $action)
    { 
        if (file_exists($action)) {         
            include_once $action;            
            return;
        }      
            
        return (new ErrorController)->error(500); 
    }

    private function array(array $action)
    {        
        $action[0] = new $action[0]();       

        if (is_callable($action)) {
            return call_user_func($action);                  
        }

        return (new ErrorController)->error(500); 
    }

    private function callable(callable $action)
    {
        if (is_callable($action)) {
            return call_user_func($action);            
        }       

        return (new ErrorController)->error(500); 
    }
}