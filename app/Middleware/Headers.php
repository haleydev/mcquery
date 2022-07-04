<?php
namespace App\Middleware;
use Core\Http\Response;
use Core\Router\Middleware;

class Headers
{
    public function json(Middleware $middleware)
    {       
        Response::header('Content-type','application/json; charset=utf-8');
        return $middleware->continue();       
    }   
}