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

        if (isset($routes['url']) and $this->method == 'GET') {
            $this->url($routes['url']);
        }

        if (isset($routes['get']) and $this->method == 'GET') {
            $this->get($routes['get']);
        }

        if (isset($routes['post']) and $this->method == 'POST') {
            $this->post($routes['post']);
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

    private function verifyToken()
    {
        // header("token: numero");
        // headers_list();

        if (isset($_SESSION['token']) and (Request::post('token'))) {
            if ($_SESSION['token'] == Request::post('token')) {
                return true;
            }
        }

        return false;
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
