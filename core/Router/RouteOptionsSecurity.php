<?php
namespace Core\Router;

class RouteOptionsSecurity
{
    public static array $options;
    private static int $id;
    private static int $total;

    public function __construct($ids, $total)
    {
        self::$id = $ids - 1;
        self::$total = $total;
    }

    /**
     * Redireciona para uma rota alternativa caso 
     * a rota atual tenha algum erro ou problemas de autenticação.
     * @param string $route
     */
    public static function redirect(string $route)
    {
        $i = 0;
        while ($i < self::$total) {
            self::$options[self::$id + $i - 1]['redirect'] = $route;
            $i++;
        }
    }
}
