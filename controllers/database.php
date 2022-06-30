<?php
namespace Controllers;
use Core\Controller;
use Core\Model\DB;
use Models\usuarios;

class database extends Controller
{
    public function render()
    {       
        $insert = DB::insert('usuarios')
        ->values([
            'nome' => 'ola',
            'email' => 'helo@hotmail.com'
        ])      
        ->execute();        
        dd($insert);

        $usuarios = usuarios::select()->coluns([usuarios::nome,usuarios::email,usuarios::id]);
        
        $teste_1 = $usuarios;
        dd($teste_1->limit(3)->where(['email' => 'null'],'!=')->execute());

        $teste_2 = $usuarios;
        dd($teste_2->remove_limit()->remove_where()->like(['id' => '%8%'])->execute());
    }
}