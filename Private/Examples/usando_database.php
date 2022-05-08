<?php
use App\Database\{DataTypes, Migration};
require "./App/Database/require.php";

// para criar um arquivo de database use o comando do mcquery:
// php mcquery database:usuarios
 
(new Migration)->table([($table = new DataTypes),$table->name("usuarios"),

    $table->id(),
    $table->string('nome',100),  
    $table->string('sobrenome', 100),
    $table->string('email',120),
    $table->string('password',100),    
    $table->string('access',20)->default('user'),
    $table->int('idade'),    
    $table->date_created(),
    $table->date_edited()

    // lembrando que se esse arquivo for 'modificado' ele sera executado novamente na proxima vez que migrate for executado 

    // para alterar uma tabela ( isso não ira dropar a coluna )
    // ao executar migrate novamente a coluna email sera alterada para login:
    // $table->alter('email',$table->string('login',120)) 

    // para remover uma coluna:
    // a coluna idade sera removida
    // $table->drop('idade')

    // para nao criar conflitos de alteracoes nas migracoes deixe apenas 1 arquivo para cada tabela do banco de dados
    // ou a exclua o arquivo de database se nao precisar usala novamente,
    // pois o mcquery verifica cada arquivo se ele não bater com o banco de dados ele faz alteracoes na tabela, entao:
    // apos dropar uma coluna remova $table->drop(),
    // apos alterar uma coluna remova $table->alter() 

],$table->result());