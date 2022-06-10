<?php
namespace App\Middleware;
use Controllers\ErrorController;
use Core\Http\Request;

class Auth
{
    public function adm()
    {
        if (isset($_SESSION['adm'])) {
            return true;         
        }

        return (new ErrorController)->error(403, 'Acesso negado');
    }

    public function user()
    {       
        if (isset($_SESSION['user']) or isset($_SESSION['adm'])) {
            return true;
        }       

        return Request::redirect(route('login'));        
    }
}