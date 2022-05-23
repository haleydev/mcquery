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

        // $this->insert = usuarios::insert([
        //     usuarios::nome => 'haley',
        //     usuarios::sobrenome => 'rodrigues',
        //     usuarios::password => hash_create('123'),
        //     usuarios::email => 'mcquery3@hotmail.com'
        // ]);
        
        // $this->usuarios = usuarios::select([
        //     'coluns' => [usuarios::nome,usuarios::email,usuarios::created_dt]
        // ]);
        
        // return template("views/testes", $this);  

        // return dd(Request::input('teste'));
        // return dd(Request::get('teste,haley'));

        $get = Request::get(['teste']);        
        if($get){
            dd($get);
        }else{
            echo 'nao';
        }
    }  
}