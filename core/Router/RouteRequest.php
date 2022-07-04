<?php
namespace Core\Router;

class RouteRequest
{
    private string $method;
    private string $url;
    private bool $checker = false;

    public function request(array $routes, string $url)
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $url;
        $this->old();     
    
        if (isset($routes['url']) and $this->method == 'GET' and $this->checker == false) {
            $this->url($routes['url']);
        }

        if (isset($routes['get']) and $this->method == 'GET' and $this->checker == false) {
            $this->get($routes['get']);
        }

        if (isset($routes['post']) and $this->method == 'POST' and $this->checker == false) {
            $this->post($routes['post']);
        }

        if (isset($routes['ajax']) and $this->method == 'POST' and $this->checker == false) {
            $this->ajax($routes['ajax']);
        }

        if (isset($routes['api']) and $this->checker == false) {
            $this->api($routes['api']);
        }

        if ($this->checker == false) {
            $this->error();
        }
        
        return;
    }

    private function url(array $routes)
    {
        if (!request()->get()) {
            foreach ($routes as $route) {
                if ($route['url'] == $this->url) {

                    define('ROUTER_PARAMS', $route['params']);

                    if ($route['middleware'] != false) {
                        $this->middleware($route['middleware']);
                    }

                    if ($this->checker == false) {
                        $this->checker = true;
                        return (new RouteAction($route['action']));
                    }

                    $this->checker = true;
                    return request()->error(403, 'Acesso negado');
                }
            }
        }

        return;
    }

    private function get(array $routes)
    {     
        foreach ($routes as $route) {
            if ($route['url'] == $this->url) {

                define('ROUTER_PARAMS', $route['params']);

                if ($route['middleware'] != false) {
                    $this->middleware($route['middleware']);
                }

                if ($this->checker == false) {
                    $this->checker = true;
                    return (new RouteAction($route['action']));
                }

                $this->checker = true;
                return request()->error(403, 'Acesso negado');
            }
        }        

        return;
    }

    private function post(array $routes)
    { 
        foreach ($routes as $route) {
            if ($route['url'] == $this->url) {

                define('ROUTER_PARAMS', $route['params']);

                if ($route['middleware'] != false) {
                    $this->middleware($route['middleware']);
                }

                if ($this->checker == false and $this->verifyToken()) {
                    $this->checker = true;
                    unset_token();
                    return (new RouteAction($route['action']));
                }

                $this->checker = true;
                return request()->error(403, 'Acesso negado');
            }
        }
        
        return;
    }

    private function ajax(array $routes)
    {        
        foreach ($routes as $route) {

            if ($route['url'] == $this->url) {

                define('ROUTER_PARAMS', $route['params']);

                if ($route['middleware'] != false) {
                    $this->middleware($route['middleware']);
                }

                if ($this->checker == false and $this->verifyToken()) {
                    $this->checker = true;
                    return (new RouteAction($route['action']));
                }

                $this->checker = true;
                return request()->error(403, 'Acesso negado');
            }
        }        

        return;
    }

    private function api(array $routes)
    {  
        foreach ($routes as $route) {
            if ($route['url'] == $this->url) {

                define('ROUTER_PARAMS', $route['params']);

                if ($route['middleware'] != false) {
                    $this->middleware($route['middleware']);
                }

                if ($this->checker == false and $this->apiMethods($route['methods'])) {
                    $this->checker = true;
                    return (new RouteAction($route['action']));
                }

                $this->checker = true;
                return request()->error(403, 'Acesso negado');
            }
        }
        
        return;
    }

    private function middleware(array $middleware)
    {
        foreach ($middleware as $class => $method) {
            $class = "\App\Middleware\\$class";
            $rum = new $class;
            $veriry = $rum->$method(new Middleware);

            if ($veriry !== true) {
                $this->checker = true;               
            }
        }

        return;
    }

    private function apiMethods(string $methods)
    {
        $allMethods = explode(',', $methods);

        foreach ($allMethods as $method) {
            if ($this->method == $method) {
                return true;
            }
        }

        return false;
    }

    private function verifyToken()
    {
        if (isset(getallheaders()['Mcquery-Token'])) {
            $token_header = getallheaders()['Mcquery-Token'];
        } else {
            $token_header = false;
        }

        if (isset($_SESSION['MCQUERY_TOKEN'])) {
            if ($_SESSION['MCQUERY_TOKEN'] == request()->post('mcquery_token') or $_SESSION['MCQUERY_TOKEN'] == $token_header) {
                return true;
            }
        }

        return false;
    }

    private function old()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            $post = request()->post();
            $get = request()->get();
            $page = $_SERVER['HTTP_REFERER'];    
    
            if ($post) {
                $_SESSION['MCQUERY_OLD'][$page] = $post;
            }
    
            if ($get) {
                $_SESSION['MCQUERY_OLD'][$page] = $get;
            }
        }      

        return;
    }

    private function error()
    {   
        $this->checker = true;
        return request()->error();
    }
}