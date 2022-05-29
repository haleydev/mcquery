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

        $select = usuarios::select([
            'where' => [
                usuarios::id => 1
            ]
        ]);

        return dd($select);


        // dd(Request::url());
        // dd(Request::urlFull());

        // dd(Request::getReplace([
        //     'teste' => 'haley',
        //     'mcquery' => null
        // ]));

        // dd(Request::get(['teste','mcquery']));        
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