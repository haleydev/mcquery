<?php
use Core\Database\Migration;
require "./Core/Resources/Database_requires.php";
    
(new Migration)->table([$table->name("usuarios"),

    $table->id(),
    $table->string('nome',100),  
    $table->string('sobrenome', 100),
    $table->string('password',100),
    $table->int('idade'),    
    $table->edited_dt(),
    $table->created_dt()

],$table->exec());