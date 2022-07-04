<?php
namespace App\Middleware;
use Core\Router\Middleware;

class Auth
{
    public function adm(Middleware $middleware)
    {
        if (isset($_SESSION['adm'])) {
            return $middleware->continue();         
        }

        return $middleware->denied();
    }

    public function user(Middleware $middleware)
    {       
        if (isset($_SESSION['user']) or isset($_SESSION['adm'])) {
            return true;
        }      

        return $middleware->redirect('/');               
    }
}