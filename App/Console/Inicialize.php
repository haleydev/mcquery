<?php
use App\Console\Console;
require './App/Console/Functions.php';

if(file_exists("./vendor/autoload.php") and file_exists(".env")){
    require './vendor/autoload.php';
    require './App/Console/env.php';
    $action = false;
}else{
    $action = true;
}

if($action == true){

    $console = (string)readline(PHP_EOL."\033[1;31mAplicação não iniciada! Deseja criar o arquivo '.env' e instala dependências ? (s/n)\033[0m").PHP_EOL.PHP_EOL;

    if($console == "s"){
        $file = new_env(); 
        file_put_contents('.env', $file);
        shell_exec('composer install');

        if(file_exists("README.md")){
            unlink("README.md");
        }

        if(file_exists("LICENSE")){
            unlink("LICENSE");
        }

        echo PHP_EOL."\033[0;32mAplicação iniciada com sucesso\033[0m".PHP_EOL.PHP_EOL;
        die();
        
    }else{        
        echo PHP_EOL."\033[1;31mOperação cancelada\033[0m".PHP_EOL.PHP_EOL;
        die();
    }      
}else{
    $console = new Console;
    $console->reader();
}