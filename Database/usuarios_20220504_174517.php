<?php
use Core\Database\Schema;
require "./Core/Resources/Database_requires.php";

$table->id();
$table->string('nome',100);
$table->string('sobrenome', 100);
$table->string('email'); 
$table->string('password',100);
$table->int('idade');    
$table->edited_dt();
$table->created_dt();
  
Schema::table('usuarios',$table->migrate());