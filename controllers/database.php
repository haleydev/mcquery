<?php
namespace Controllers;
use Core\Model\DB;
use Models\filmes;
use Models\usuarios;

class database
{
    public function render()
    {   
        // $update = DB::update('filmes')->values([
        //     filmes::popular => null
        // ])->where([filmes::popular => ''])->execute();

        // return dd($update);        

        // usuarios::insert()->values([
        //     usuarios::nome => 'haley',
        //     usuarios::idade => 25
        // ])->execute();
        // return;

        $filmes = DB::select('filmes')
        // ->coluns(['count(id)'])
      //   ->where([filmes::id => 100],'=')
      //  ->coluns(['id','titulo',filmes::descricao])
        // ->whereNotNull([filmes::popular])
        // ->whereIsNull([filmes::popular])
       // ->where([filmes::descricao => '%hacker%'],'LIKE')
       
        ->whereRaw('id IN (SELECT id FROM usuarios)')       
        ->orderBy('id ASC')
        //->whereIsNull([filmes::trailer])
        //->whereNotNull([filmes::genero])
        ->limit(100,1)
        //->getQuery();
        ->execute();
        //->query;

        if(!$filmes) {
            echo 'nenhum filme encontrado';
        }else{
            dd($filmes);
        }
      
    }
}