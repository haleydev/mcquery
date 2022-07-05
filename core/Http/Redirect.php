<?php
namespace Core\Http;
use Controllers\ErrorController;
use Core\Template\Template;

class Redirect
{
    /**
     * Redirecionar para uma uma rota nomeada
     */
    public static function route($route, $response = 302)
    {
        header('Location: ' . route($route) , true, $response);
        die;
    }

    /**
     * Retorna a pagina de erro 
     */
    public static function error($response = 404, $msg = null)
    {        
        return (new ErrorController)->error($response, $msg);
    }

    /**
     * Renderiza um template.
     * @param array|object $params
     * @return template
     */
    function template(array|object $params = [], $response = 302)
    { 
        http_response_code($response);
        return new Template($params);
    }
}