<?php
namespace Core\Router;

class RouteResolve
{
    private string $url;
    private array $names = [];
    private array $routes = [];    

    public function __construct()
    {
        $this->url = filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_SANITIZE_URL);
    }

    public function collection(array $routes, array $sessions, array|bool $security, array $options)
    {
        $this->routes = $routes;

        if (isset($this->routes['url'])) {
            foreach ($this->routes['url'] as $key => $value) {
                $this->agroup('url', $key, $sessions, $security, $options);
            }
        }

        if (isset($this->routes['get'])) {
            foreach ($this->routes['get'] as $key => $value) {
                $this->agroup('get', $key, $sessions, $security, $options);
            }
        }

        if (isset($this->routes['post'])) {
            foreach ($this->routes['post'] as $key => $value) {
                $this->agroup('post', $key, $sessions, $security, $options);
            }
        }        
   
        if (isset($this->routes['ajax'])) {
            foreach ($this->routes['ajax'] as $key => $value) {
                $this->agroup('ajax', $key, $sessions, $security, $options);
            }
        }     

        if (isset($this->routes['api'])) {
            foreach ($this->routes['api'] as $key => $value) {
                $this->agroup('api', $key, $sessions, $security, $options);
            }
        } 

        define('ROUTER_NAMES', $this->names);
        return (new RouteRequest($this->routes, $this->url));
    }

    private function agroup(string $method, string $key, array $sessions, array|bool $security, array $options)
    {
        if (isset($options[$key]['name'])) {
            $this->routes[$method][$key]['name'] = $options[$key]['name'];
            $this->names[$options[$key]['name']] = $this->names($this->routes[$method][$key]['route']);
        } else {
            $this->routes[$method][$key]['name'] = false;
        }

        if (isset($sessions[$key])) {
            $this->routes[$method][$key]['session'] = $sessions[$key];
        } else {
            $this->routes[$method][$key]['session'] = false;
        }

        if ($security != false) {
            if (isset($security[$key]['redirect'])) {
                $this->routes[$method][$key]['redirect'] = $security[$key]['redirect'];
            } else {
                $this->routes[$method][$key]['redirect'] = false;
            }
        } else {
            $this->routes[$method][$key]['redirect'] = false;
        }

        return $this->routes;
    }

    public function routeParams(string $route)
    {
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $for_view)) {
            $array_url_view = explode('/', $route);
            $array_url_get = explode('/', $this->url);

            if (count($array_url_view) == count($array_url_get)) {
                $new_url = "";
                $params = array();
                foreach ($for_view[0] as $variable) {
                    if ($new_url != null) {
                        $array_url_view = explode('/', $new_url);
                    }
                    $url_key = array_search($variable, $array_url_view);
                    $key_view = $array_url_get[$url_key];

                    $replacement = array($url_key => $key_view);
                    $replace_array_url = array_replace($array_url_view, $replacement);
                    $new_url = implode("/", $replace_array_url);
                    $id_view = $array_url_view[$url_key];

                    if (preg_match_all($patternVariable, $id_view, $define_view)) {
                        $defid_url = $key_view;
                    }
                    $params[$define_view[1][0]] = $defid_url;
                }

                return [
                    'url' => $new_url,
                    'params' => $params
                ];
            }
        }

        return [
            'url' => $route,
            'params' => null
        ];
    }

    private function names(string $route_name)
    {
        if (str_contains($route_name, '{')) {
            $array_url_view = explode('/', $route_name);
            $string = "";
            foreach ($array_url_view as $variable) {
                if (!str_contains($variable, '{')) {
                    $string .= $variable . "/";
                } else {
                    $string .= "{id}" . "/";
                }
            }
            $url = $string;
        } else {
            $url = $route_name;
        }

        return URL . $url;
    }
}