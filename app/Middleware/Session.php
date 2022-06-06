<?php
namespace App\Middleware;
use Controllers\ErrorController;
use Core\Http\Request;

class Session
{
    public function adm()
    {
        if (!isset($_SESSION['adm'])) {
            return (new ErrorController)->error(403, 'Acesso negado');
        }

        return true;      
    }

    public function user()
    {
        if (!isset($_SESSION['user'])) {
            return Request::redirect('/login');
        }

        return true;
    }
}