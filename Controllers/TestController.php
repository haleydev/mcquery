<?php
namespace Controllers;
use Core\Controller;
use Models\example;

class TestController extends Controller
{
    public function render()
    {  
        $this->title = "testes";
        $this->view = "views/teste";        
       
        // $test = example::insert([
        //     'nome' => 'warley'
        // ]);  
        // dd($test);     

        return template("layouts/main", $this);
    }
}