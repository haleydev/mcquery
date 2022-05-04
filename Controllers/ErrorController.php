<?php
namespace Controllers;
use Core\Controller;
use Models\usuarios;

class ErrorController extends Controller
{
    public function render()
    {
        $this->title = "Pagina não encontrada";
        http_response_code(404); 
                 
        return template("views/error",$this);        
    }
}