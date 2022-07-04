<?php
namespace Controllers;
use Core\Validator;

class ajaxController
{
    public function render()
    {  
        $validator = new Validator(request()->all());  
        $validator->required('email','email requerido'); 
        $validator->required('nome','nome requerido'); 
        $validator->email('email'); 
        $validator->numeric('nome');
        $validator->register();

        if($validator->errors() != false){
            return request()->redirect(route('testes'));
        }else{
            echo 'logado';
        }        
      

        //return dd($validator->errors());
        // return Response::json($validator->error_fist());
    }
}