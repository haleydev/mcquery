<?php
namespace Core\Router;

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
        return redirect()->error(403, $msg);
    }

    /**
     * Redirecionamentos
     */
    public function redirect($url = null, $response = 302)
    { 
        return redirect($url, $response);
    }
}