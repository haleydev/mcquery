<?php
namespace Controllers\testes;
use Core\Controller;

class testeController extends Controller
{
    public function render()
    {  
        $this->view = "";
        $this->title = "";       

        return template("layouts/main", $this); 
    }
}