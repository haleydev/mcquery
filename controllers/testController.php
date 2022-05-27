<?php
namespace Controllers;
use Core\Controller;
use Core\Http\Request;
use Models\usuarios;

class testController extends Controller
{
    public function render()
    {  
        // $this->view = "views/teste";
        // $this->title = "formulario";

        $this->insert = usuarios::insert([
            usuarios::nome => 'haley',
            usuarios::sobrenome => 'rodrigues',
            usuarios::password => hash_create('123'),
            usuarios::email => 'mcquery3@hotmail.com'
        ]);        
        
        dd(Request::urlFull());
        dd(Request::getReplace([
            'teste' => 'haley',
            'mcquery' => 'frame wor?sdfgdsg5e6 <?php  k'
        ]));

        dd(Request::get(['teste','mcquery']));

        // $this->insert = usuarios::insert([
        //     usuarios::nome => Request::get('mcquery'),           
        // ]);

        // dd(usuarios::select([
        //     'coluns' => usuarios::nome
        // ]));
    }  
}