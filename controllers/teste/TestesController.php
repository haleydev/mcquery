<?php
namespace Controllers\teste;
use Core\Controller;

class TestesController extends Controller
{
    public function render()
    {  
        $this->view = "";
        $this->title = "";       

        return template("layouts/main", $this); 
    }
}