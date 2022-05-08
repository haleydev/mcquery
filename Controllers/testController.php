<?php
namespace Controllers;
use Core\Controller;
use Models\usuarios;

class testController extends Controller
{
    public function render()
    {  
        $this->view = "views/teste";
        $this->title = "formulario";

        $this->usuarios = usuarios::select([
            'coluns' => [usuarios::nome,usuarios::email,usuarios::created_dt]
        ]);
        
        return template("layouts/main", $this); 
    }

    public function login()
    {
        if(post_check('nome,email,senha')){

            usuarios::insert([
                usuarios::nome => $_POST['nome'],
                usuarios::email => $_POST['email'],
                usuarios::password => hash_create($_POST['senha']),
            ]);

            session_mesage('conta criada');
            redirect(router('formulario'));  
        }else{
            session_mesage('preencha todos os campos');
            redirect(router('formulario'));  
        }          
    }

    public function pesquisa()
    {
        if(post_check('pesquisa')){
            if(strlen($_POST['pesquisa']) > 3){     

                $pesquisa = usuarios::select([
                    'like' => [
                        usuarios::nome => $_POST['pesquisa'],
                        usuarios::email => $_POST['pesquisa']
                    ]
                ]);
                       
                if($pesquisa == null){
                    echo "sem resultados";
                }else{
                    echo "Total: ".count($pesquisa);
                    foreach($pesquisa as $user):?>
                        <p>Nome: <?=$user['nome']?> - Email:<?=$user['email']?> </p>       
                    <?php endforeach;
                }
            }
        }
    }
}