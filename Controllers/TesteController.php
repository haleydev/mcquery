<?php
namespace Controllers;
use App\Controller;
use Models\usuarios;

class TesteController extends Controller
{
    public function render()
    {  
        $this->title = "testes";
        $this->view = "views/teste";
        
        $this->usuarios = usuarios::select([
            "coluns" => "nome,created_dt",
        ]);

        return template("layouts/main", $this); 
    }
}