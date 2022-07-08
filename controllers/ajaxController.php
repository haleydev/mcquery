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
        $validator->letters('nome');
        $validator->required('money');       
        $validator->email('email');      
        $validator->int('idade');    
        $validator->min_value('idade',18,'muito novo');
        $validator->max_value('idade',60,'muito veio');   
        $validator->size('idade',2);    
        $validator->min('nome',5);
        $validator->max('nome',255);
        $validator->url('url');       
        $validator->number_formart('telefone','(xx) xxxxx-xxxx'); 
        $validator->replace('money','.','');  
        $validator->replace('money',',','.');   
        $validator->float('money');  
        $validator->register();   
        
        $telefone = $validator->get('telefone');
        $money = $validator->get('money');
       
        

        if($validator->errors() == false){
            return template(['money' => $money])->view('testes');
        }else{      
            return redirect()->template(['money' => $money])->view('testes');
        }

        // return dd($validator->errors());
        // return Response::json($validator->error_fist());
    }
}