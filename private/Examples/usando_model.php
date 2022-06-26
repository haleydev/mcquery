<?php

use Core\Model\DB;

$select = DB::select('usuarios')
->where(['nome' => 'ppp'])
->order('RAND()')
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
->update(['nome' => 'novo nome'])
->where(['nome' => 'ppp'])
->limit(1) 
->execute();        
dd($update);