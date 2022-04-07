<?php
namespace Controllers;
use App\Controller;

class ErrorController extends Controller
{        
    public $title = "Pagina não encontrada";   

    public function render(){
        http_response_code(404);      
        $this->view("error");        
    }
}