<?php
namespace Core\Router;

class Route
{
    private static array $routes = [];
    private static array $middleware = [];
    private static int $count = 0;

    public static function url(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['url'][self::$count] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$count++;
        return new RouteOptions(self::$count);
    }

    public static function get(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['get'][self::$count] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$count++;
        return new RouteOptions(self::$count);
    }

    public static function post(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['post'][self::$count] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$count++;
        return new RouteOptions(self::$count);
    }

    public static function ajax(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['ajax'][self::$count] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$count++;
        return new RouteOptions(self::$count);
    }

    public static function api(string $route, string|array|callable $action, string $methods = 'POST')
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['api'][self::$count] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action,
            'methods' => $methods
        ];

        self::$count++;
        return new RouteOptions(self::$count);
    }

    public static function middleware(array $middleware, callable $routes)
    {
        $count = self::$count;
        
        if (is_callable($routes)) {
            call_user_func($routes);
        }

        $total = self::$count - $count;
       
        $i = 0;

        while ($i < $total) {  
            self::$middleware[$count + $i] = $middleware;
            $i++;           
        }   
        
        return;
    }

    public static function end()
    { 
        (new RouteResolve)->collection(
            self::$routes, 
            RouteOptions::$options,
            self::$middleware
        );       
    }
}