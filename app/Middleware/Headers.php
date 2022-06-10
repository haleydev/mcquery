<?php
namespace App\Middleware;

class Headers
{
    public function json()
    {
        header("Content-type: application/json; charset=utf-8");
        return true;       
    }   
}