<?php
namespace Controllers;
use Core\Model\DB;
use Models\filmes;

class database
{
    public function render()
    {   
        
        // $delete = usuarios::delete()->where([
        //     usuarios::nome => 'haley'
        // ])->limit(100)->execute();
        // dd($delete);

        // $haley = haley::insert()->values([
        //     haley::nome => 'database',
        //     haley::sobrenome => 'query',
        //     haley::idade => 25            
        // ])->execute();
        // dd($haley);

        // $insert = usuarios::insert()->values([
        //     usuarios::nome => 'database',
        //     usuarios::sobrenome => 'query',
        //     usuarios::idade => 25            
        // ]);
        // dd($insert);

        // $update = DB::update('usuarios')->values(['nome' => 'teste'])->where(['nome' => 'mc'])->execute();
        // dd($update);

        // $count = DB::select('usuarios')->coluns(['COUNT(id) as total,nome'])->group_by('nome')->execute();        
        // dd($count);

        // $usuarios = usuarios::select()->limit(3)->order('RAND()')->coluns('nome,sobrenome');
        
        // $teste_1 = $usuarios;
        // dd($teste_1->execute());

        // $teste_2 = $usuarios;
        // dd($teste_2->remove_where()->remove_order()->execute());

 
        

         
        // $filmes = DB::select('filmes')
        // ->where(['id' => '>'], 'is');

    }
}