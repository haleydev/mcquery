<?php
namespace Controllers;
use Core\Controller;
use Models\usuarios;

class HomeController extends Controller
{
    public function home()
    {          
        //$usuarios = usuarios::select()->execute();       
        
        $return = [
            'title' => 'haley aaa'            
        ];                 
        return template('views/home', $return); 
    }
}