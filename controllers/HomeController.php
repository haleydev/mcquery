<?php
namespace Controllers;
use Core\Controller;

class HomeController extends Controller
{
    public function home()
    { 
        $this->view = 'views/home';
        $this->title = 'MCQUERY';              
                              
        return template('layouts/main', $this); 
    }
}