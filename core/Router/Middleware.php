<?php
namespace Core\Router;
use Core\Http\Request;
use Core\Template\Template;

class Middleware
{
    /**
     * Continua execução das rotas.
     */
    public function continue()
    {
        return true;
    }

    /**
     * Retorna pagina de acesso negado.
     */
    public function denied($msg = null)
    {
        return Request::error(403, $msg);
    }

    /**
     * Redireciona para uma url.
     */
    public function redirect($route, $code = 302)
    {
        return Request::redirect($route, $code);
    }

    /**
     * Renderiza um template.
     * @param array|object $params
     * @return template
     */
    function template(array|object $params = [])
    { 
        return new Template($params);
    }
}