<?php
namespace Controllers;
use Core\Controller;
use Core\Http\Request;
use Models\usuarios;

class testController extends Controller
{
    public function render()
    {  
        // header('Content-Type: image/png');
        // dd();

        return template('views/testes');


        // $this->view = "views/teste";
        // $this->title = "formulario";

        // $insert = usuarios::insert([
        //     usuarios::nome => 'haley',
        //     usuarios::sobrenome => 'rodrigues',
        //     // usuarios::password => hash_create('123'),
        //     usuarios::email => 'mcquery3@hotmail.com'
        // ]);             

        // usuarios::delete([
        //     'where' => [
        //     usuarios::email => '',
        //     usuarios::id => ''
        //     ]
        // ]);

        // $update = usuarios::update([
        //     'where' => [
        //         usuarios::nome => 'haley'
        //     ],

        //     'update' => [
        //         usuarios::nome => 'teste'
        //     ]
        // ]);

  




        dd(Request::url());
        dd(Request::urlFull());

        // dd(Request::getReplace([
        //     'teste' => 'haley',
        //     'mcquery' => null
        // ]));

        dd(Request::get());        
        // dd(Request::post(['teste','mcquery']));

        // dd(Request::route('form'));      

        // $this->insert = usuarios::insert([
        //     usuarios::nome => Request::get('mcquery'),           
        // ]);

        // dd(usuarios::select([
        //     'coluns' => usuarios::nome
        // ]));
    }  
}