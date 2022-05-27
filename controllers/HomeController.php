<?php
namespace Controllers;
use Core\Controller;

class HomeController extends Controller
{
     public function render()
    { 
        $this->view = 'views/home';
        $this->title = 'MCQUERY';
        $this->teste = 'string teste';     
               
        // return dd(produto::select([
        //     "coluns" => [
        //         produto::nome,
        //         produto::codigo_barras
        //     ],
        //     "limit" => 20
        // ]));
        
        return template('layouts/main', $this); 
    }
}