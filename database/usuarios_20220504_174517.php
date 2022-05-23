<?php
use Core\Database\Schema;
require "./core/Resources/Database_requires.php";

$table->id();
$table->string('nome',100);
$table->string('sobrenome', 100);
$table->string('email')->unique(); 
$table->string('password',100);
$table->int('idade');    
$table->edited_dt();
$table->created_dt();
  
// return var_dump($table->migrate());
Schema::table('usuarios',$table->migrate());