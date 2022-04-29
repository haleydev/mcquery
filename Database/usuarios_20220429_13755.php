<?php
require "./App/Database/require.php";
    
(new App\Database\Migration)->table([$table->name("usuarios"),

    $table->id(),
    $table->alter('idade',$table->decimal('saldo')),
    $table->string('nome',100),  
    $table->string('sobrenome', 100),
    $table->string('password',100),
        
    $table->edited_dt(),
    $table->created_dt()

],$table->result());