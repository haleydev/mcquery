<?php
namespace Controllers;
use Core\Controller;
use Core\Http\Request;

class postController extends Controller
{
    public function render()
    {  
        dd(Request::post('nome')) ;   
    }
}