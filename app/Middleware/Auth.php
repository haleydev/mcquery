<?php
namespace App\Middleware;
use Controllers\ErrorController;
use Core\Router\Middleware;

class Auth
{
    public function adm()
    {
        if (isset($_SESSION['adm'])) {
            return true;         
        }

        return (new ErrorController)->error(403, 'Acesso negado');
    }

    public function user(Middleware $middleware)
    {       
        if (isset($_SESSION['user']) or isset($_SESSION['adm'])) {
            return true;
        }      

        return $middleware->redirect('/');               
    }
}