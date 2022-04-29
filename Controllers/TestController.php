<?php
namespace Controllers;
use App\Controller;
use Models\usuarios;

class TestController extends Controller
{
    public function render()
    {  
        $this->title = "testes";
        $this->view = "views/teste";
        
        $this->usuarios = usuarios::select([
            "coluns" => "nome,created_dt",
        ]);

        // usuarios::delete();

        return template("layouts/main", $this); 
    }
}