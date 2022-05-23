<?php
namespace Controllers;
use Core\Controller;

class PostController extends Controller
{
    public function render()
    {  
        $this->view = "";
        $this->title = "";       

        return template("layouts/main", $this); 
    }
}