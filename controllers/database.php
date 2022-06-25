<?php
namespace Controllers;
use Core\Controller;
use Core\Model\DB;
use Models\teste;
use Models\usuarios;

class database extends Controller
{
    public function render()
    {  
        // $select = DB::select('usuarios')
        // ->where(['nome' => 'ppp'])
        // ->order('RAND()')
        // ->coluns(['id','nome'])
        // ->limit(5)
        // ->execute();        
        // dd($select);

        // $select_one = DB::selectOne('usuarios')
        // ->where(['nome' => 'ppp'])
        // ->order('RAND()')
        // ->coluns(['id','nome'])       
        // ->execute();        
        // dd($select_one);

        // $insert = DB::insert('usuarios')
        // ->insert(['nome' => 'ola'])       
        // ->execute();        
        // dd($insert);

        // $delete = DB::delete('usuarios')
        // ->where(['nome' => 'ppp'])
        // ->limit(1) 
        // ->execute();        
        // dd($delete);

        // $update = DB::update('usuarios')
        // ->update(['nome' => 'novo nome'])
        // ->where(['nome' => 'ppp'])
        // ->limit(1) 
        // ->execute();        
        // dd($update);

        // $teste = teste::select()->limit(1)->execute();
        // dd($teste);

        $usuarios = usuarios::select()
        ->coluns([usuarios::nome,usuarios::email])
        ->limit(5)
        ->execute();
        return dd($usuarios);
    }
}