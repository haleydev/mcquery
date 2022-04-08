<?php
if(!file_exists("./.env") or !file_exists("./vendor")){
    die("Aplicação não iniciada! use o comando 'php mcquery env' para criar o arquivo de configuração e instalar dependências.");
}

ob_start();

if(!isset($_SESSION)){
    session_start();    
}

require 'App/Mcquery/env.php';

date_default_timezone_set(env('timezone'));
define("URL", env('URL'));   

require 'Helpers.php';

require 'vendor/autoload.php';

use App\Router;
$router = new Router; 