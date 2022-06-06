<?php
use Core\Database\Schema;
require "./core/Resources/Database_requires.php";

$table->id();
  
Schema::table('permissoes',$table->migrate());