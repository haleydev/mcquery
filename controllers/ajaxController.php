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
        $validator->required('idade','informe sua idade');
        $validator->email('email'); 
        $validator->numeric('idade');
        $validator->min('nome',5);
        $validator->register();

        // dd($validator->errors());
        // dd($validator->error_fist());
        // return;

        if($validator->errors() == false){
            echo 'logado';
        }else{            
            return request()->redirect(route('testes'));
        }        
      

        // return dd($validator->errors());
        // return Response::json($validator->error_fist());
    }
}