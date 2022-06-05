<?php
namespace Core\Router;

use Controllers\ErrorController;
use Core\Http\Request;

class RouteRequest
{
    
    private string $method;
    private string $url;
    private bool $checker = false;

    public function __construct(array $routes, string $url)
    {
        $this->method = $_SERVER['REQUEST_METHOD'];        
        $this->url = $url;

        $this->old();

        if (isset($routes['url']) and $this->method == 'GET') {
            $this->url($routes['url']);
        }

        if (isset($routes['get']) and $this->method == 'GET') {
            $this->get($routes['get']);
        }

        if (isset($routes['post']) and $this->method == 'POST') {
            $this->post($routes['post']);
        }

        if (isset($routes['ajax']) and $this->method == 'POST') {
            $this->ajax($routes['ajax']);
        }

        if (isset($routes['api'])) {
            $this->api($routes['api']);
        }
    }

    private function url(array $routes)
    {
        if (!Request::get() and $this->checker == false) {
            foreach ($routes as $value) {
                if ($value['url'] == $this->url) {
                    if ($this->verifySession($value['session']) == true) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return (new RouteAction($value['action']));
                    }
                   
                    if ($value['redirect'] != false) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return Request::redirect($value['redirect']);
                    }

                    $this->checker = true;
                    return (new ErrorController)->error(403, 'Acesso negado');
                }
            }
        }

        return;
    }

    private function get(array $routes)
    {
        if ($this->checker == false) {
            foreach ($routes as $value) {                
                if ($value['url'] == $this->url) {
                    if ($this->verifySession($value['session']) == true) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return (new RouteAction($value['action']));
                    }

                    if ($value['redirect'] != false) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return Request::redirect($value['redirect']);
                    }      

                    $this->checker = true;
                    return (new ErrorController)->error(403, 'Acesso negado');   
                }
            }
        }

        return;
    }

    private function post(array $routes)
    {
        if ($this->checker == false) {
            foreach ($routes as $value) {
                if ($value['url'] == $this->url) {
                    if ($this->verifyToken() and $this->verifySession($value['session']) == true) {
                        $this->checker = true;
                        unset_token();
                        define('ROUTER_PARAMS', $value['params']);                       
                        return (new RouteAction($value['action']));                      
                    }                  

                    if ($value['redirect'] != false) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return Request::redirect($value['redirect']);
                    }
    
                    $this->checker = true;
                    return (new ErrorController)->error(403, 'Acesso negado');                 
                }              
            }
        }

        return;
    }

    private function ajax(array $routes)
    {
        if ($this->checker == false) {
            foreach ($routes as $value) {
                if ($value['url'] == $this->url) {
                    if ($this->verifyToken() and $this->verifySession($value['session']) == true) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return (new RouteAction($value['action']));                      
                    }                  

                    if ($value['redirect'] != false) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return Request::redirect($value['redirect']);
                    }
    
                    $this->checker = true;
                    return (new ErrorController)->error(403, 'Acesso negado');                 
                }              
            }
        }

        return;
    }

    private function api(array $routes)
    {
        if ($this->checker == false) {
            foreach ($routes as $value) {
                if ($value['url'] == $this->url) {
                    if($this->apiMethods($value['methods'])) {
                        if ($this->verifySession($value['session']) == true) {
                            $this->checker = true;
                            define('ROUTER_PARAMS', $value['params']);
                            return (new RouteAction($value['action']));                      
                        } 
                    }                
    
                    if ($value['redirect'] != false) {
                        $this->checker = true;
                        define('ROUTER_PARAMS', $value['params']);
                        return Request::redirect($value['redirect']);
                    }
    
                    $this->checker = true;
                    return (new ErrorController)->error(403, 'Acesso negado'); 
                }              
            }
        }

        return;
    }

    private function verifySession(string|array $session)
    {      
        if ($session == false || $session == null) {
            return true;
        }

        if(is_string($session)){
            $sessions = explode(',', $session);

            foreach ($sessions as $value) {
                if (isset($_SESSION[$value])) {
                    return true;                    
                }
            }  

            return false;
        }   
       

        if (is_array($session)) {
            foreach ($session as $key => $value) {
                if (isset($_SESSION[$key])) {
                    if ($_SESSION[$key] == $value) {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }    
        
        return false;
    }

    private function apiMethods(string $methods)
    {       
        $allMethods = explode(',',$methods);

        foreach ($allMethods as $method){
            if($this->method == $method) {
                return true;
            }
        }

        return false;
    }

    private function verifyToken()
    {        
        if (isset(getallheaders()['Mcquery-Token'])) {
            $token_header = getallheaders()['Mcquery-Token'];            
        }else{
            $token_header = false;
        }       

        if (isset($_SESSION['MCQUERY_TOKEN'])) {
            if ($_SESSION['MCQUERY_TOKEN'] == Request::post('mcquery_token') or $_SESSION['MCQUERY_TOKEN'] == $token_header) {
                return true;
            }
        }

        return false;
    }

    private function old()
    {
        $post = Request::post();
        $get = Request::get();
   
        if($post) {
            $_SESSION['MCQUERY_OLD'] = $post;
        }

        if($get) {
            $_SESSION['MCQUERY_OLD'] = $get;
        }

        return;
    }

    private function error()
    {
        if ($this->checker === false) {
            return (new ErrorController)->error();
        }
    }

    public function __destruct()
    {
        $this->error();
    }
}
