<?php
namespace Controllers;
use Core\Controller;

class formController extends Controller
{
    public function render()
    {  
        return template("views/testes", $this); 
    }
}