<?php
namespace Controllers;
use Core\Http\Response;
use Models\usuarios;

class ApiController
{
    public function api()
    {   
        $select = usuarios::select()->coluns(['id','nome','email']);

        if(request()->all('id')){
            $select->where(['id' => request()->all('id')]);
        }        

        if(request()->all('nome')){
            $select->where(['nome' => request()->all('nome')]);
        }   
         
        
        return Response::json($select->execute());  
    }
} 