<?php
namespace Controllers;

use Core\Controller;
use Models\usuarios;

class TestController extends Controller
{
    public function render()
    {  
        $this->title = "testes";
        $this->view = "views/teste";

        return template("layouts/main", $this);
    }
}