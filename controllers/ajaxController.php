<?php
namespace Controllers;
use Core\Controller;
use Core\Http\Request;

class ajaxController extends Controller
{
    public function render()
    {          
        return dd(Request::post(['nome','email'])); 
    }
}