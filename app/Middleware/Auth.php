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
       
        return $middleware->redirect()->route('home');   
    }

    public function user(Middleware $middleware)
    {
        if (isset($_SESSION['user'])) {
            return $middleware->continue();
        }      

        return $middleware->redirect('/');
    }
}