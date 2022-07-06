<?php
namespace Core\Http;
use Controllers\ErrorController;
use Core\Template\Template;

class Redirect
{
    /**
     * Redirecionar para uma uma rota nomeada
     */
    public static function route(string $route,int $response = 302)
    {
        return header('Location: ' . route($route) , true, $response);       
    }

    /**
     * Retorna a pagina de erro 
     */
    public static function error(int $response = 404, string $msg = null)
    {        
        return (new ErrorController)->error($response, $msg);
    }

    /**
     * Renderiza um template.
     * @param array|object $params
     * @return template
     */
    public function template(array|object $params = [], int $response = 302)
    { 
        http_response_code($response);
        return new Template($params);
    }

    /**
     * Redireciona para pagina anterior se existir ou pagina 404
     */
    public function back(int $response = 302)
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            return header('Location: ' . $_SERVER['HTTP_REFERER'] , true, $response);
        }else{
            redirect()->error();
        }
    }
}