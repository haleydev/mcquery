<?php
namespace Controllers;
use Core\Validator;

class ajaxController
{
    public function render()
    {  
        $validator = new Validator(request()->all());  
        $validator->mold('<p class="error">','</p>');
        $validator->required('email','email requerido'); 
        $validator->required('nome','nome requerido'); 
        $validator->required('idade','informe sua idade');
        $validator->required('url','mande sua url');
        $validator->required('telefone','informe seu telefone');       
        $validator->email('email');      
        $validator->numeric('idade');      
        $validator->min_value('idade',18,'muito novo');
        $validator->max_value('idade',60,'muito veio');   
        $validator->size('idade',2);    
        $validator->min('nome',5);
        $validator->max('nome',255);
        $validator->url('url');       
        $telefone = $validator->number_formart('telefone','(xx) xxxxx-xxxx'); 
        $validator->register();       

        // dd($validator->errors());
        // dd($validator->error_fist());
        // return;

        if($validator->errors() == false){
            dd($telefone);
        }else{            
            return redirect()->back();
        }

        // return dd($validator->errors());
        // return Response::json($validator->error_fist());
    }
}