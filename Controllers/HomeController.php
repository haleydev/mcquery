<?php
namespace Controllers;
use Core\Controller;

class HomeController extends Controller
{
    public function render()
    {  
        $this->view = 'views/home';
        $this->title = 'MCQUERY';
        $this->teste = 'string teste';       

        return template('layouts/main', $this); 
    }
}