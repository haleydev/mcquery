<?php
namespace Core\Router;

class Route
{
    private static array $routes = [];
    private static array $sessions = [];
    private static array|bool $security;
    private static int $options = 0;

    public static function url(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['url'][self::$options] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$options++;
        return new RouteOptions(self::$options);
    }

    public static function get(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['get'][self::$options] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$options++;
        return new RouteOptions(self::$options);
    }

    public static function post(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['post'][self::$options] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$options++;
        return new RouteOptions(self::$options);
    }

    public static function ajax(string $route, string|array|callable $action)
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['ajax'][self::$options] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action
        ];

        self::$options++;
        return new RouteOptions(self::$options);
    }

    public static function api(string $route, string|array|callable $action, string $methods = 'POST')
    {
        $params = (new RouteResolve)->routeParams($route);
        self::$routes['api'][self::$options] = [
            'url' => $params['url'],
            'params' => $params['params'],
            'route' => $route,
            'action' => $action,
            'methods' => $methods
        ];

        self::$options++;
        return new RouteOptions(self::$options);
    }

    /**
     * @param strig $session 'adm,user' Varias seções separadas por virgula.
     * @param array $session ['auth' => user] Sendo auth nome da seção e user seu valor.
     * @param callable $routes
     */
    public static function session(array|string $session, callable $routes)
    {
        $count = self::$options;
        
        if (is_callable($routes)) {
            call_user_func($routes);
        }

        $total = self::$options - $count;
       
        $i = 0;

        while ($i < $total) {
            self::$sessions[$count + $i] = $session;
            $i++;           
        }
        
        return new RouteOptionsSecurity(self::$options, $total);
    }

    public function __destruct()
    {
        if (isset(RouteOptionsSecurity::$options)) {
            self::$security = RouteOptionsSecurity::$options;
        } else {
            self::$security = false;
        }
          
        (new RouteResolve)->collection(
            self::$routes,
            self::$sessions,
            self::$security,
            RouteOptions::$options
        );       
    }
}