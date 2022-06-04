<?php
namespace Core\Router;

class RouteOptions
{ 
    public static array $options;
    private static int $id;

    public function __construct($ids)
    {
        self::$id = $ids - 1;
    }
  
    public static function name(string $name = null)
    { 
        self::$options[self::$id]['name'] = $name;    
        return (new RouteOptions(self::$id)); 
    } 
}