<?php
namespace Controllers;
use App\Controller;

class HomeController extends Controller
{  
    public $title = "mcquery";
    public $view = "home";  
   
    public function render()
    {         
        $this->layout('main');  
    }
}