<?php
namespace Controllers;
use Core\Controller;

class testController extends Controller
{
    public function render()
    {  
        $this->view = "views/teste";
        $this->title = "formulario";
        
        return template("layouts/main", $this); 
    }

    public function login()
    {
        if(post_check('novo_usuario')){
            session_mesage('conta criada com sucesso');
        }else{
            session_mesage('preencha todos os campos');
        }

        redirect(router('formulario'));    
    }
}