<?php
namespace Core\Router;
use Core\Http\Request;

class Middleware
{
    public function continue()
    {
        return true;
    }

    public function denied()
    {
        return Request::redirectError(403);
    }

    public function redirect($route, $code = 302)
    {
        return Request::redirect($route, $code);
    }
}