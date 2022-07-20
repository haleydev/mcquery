<?php
namespace Controllers;
use Core\Model\DB;
use Models\filmes;

class database
{
    public function render()
    {   
        // $update = DB::update('filmes')
        // ->values([
        //     filmes::genero => 'm'
        // ])->execute();

        // dd($update);
        

        $filmes = DB::select('filmes')
       // ->coluns(['count(distinct media_votos)'])
       // ->where([filmes::id => 100],'=')
       ->coluns(['popular'])
       ->whereNotNull([filmes::popular])
       ->where([filmes::popular => ''], '!=')
       ->distinct()
        // ->orderBy('rand()')
        //->whereIsNull([filmes::trailer])
        //->whereNotNull([filmes::genero])
        // ->limit(100)
       // ->getQuery();
        ->execute();
        //->query;

        dd($filmes);
    }
}