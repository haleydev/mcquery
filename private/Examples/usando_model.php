<?php

use Core\Model\DB;
use Models\usuarios;

$select = DB::select('usuarios')
->where(['nome' => 'ppp'])
->order_by('RAND()')
->coluns(['id','nome'])
->limit(5)
->execute();        
dd($select);

$select_one = DB::selectOne('usuarios')
->where(['nome' => 'ppp'])
->order('RAND()')
->coluns(['id','nome'])       
->execute();        
dd($select_one);

$insert = DB::insert('usuarios')
->values(['nome' => 'ola'])       
->execute();        
dd($insert);

$delete = DB::delete('usuarios')
->where(['nome' => 'ppp'])
->limit(1) 
->execute();        
dd($delete);

$update = DB::update('usuarios')
->values(['nome' => 'novo nome'])
->where(['nome' => 'ppp'])
->limit(1) 
->execute();        
dd($update);

// usando remove
$usuarios = usuarios::select()->coluns([usuarios::nome,usuarios::email,usuarios::id]);

$teste_1 = $usuarios;
dd($teste_1->limit(3)->where(['email' => 'null'],'!=')->execute());

$teste_2 = $usuarios;
dd($teste_2->remove_limit()->where(['id' => '%8%'],'LIKE')->execute());

$filmes = DB::select('filmes')      
->coluns(['media_votos as media',
'CASE media_votos
    WHEN media_votos > 8 THEN "alto"
    WHEN media_votos < 5 THEN "baixo"
    ELSE "TESTE"
END as media'
])->limit(900)->order_by('RAND()');     

return dd($filmes->execute());