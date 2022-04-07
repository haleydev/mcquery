<?php
ob_start();

if(!isset($_SESSION)){
    session_start();    
}

if(!file_exists("./config.ini") or !file_exists("./vendor")){
    die("Aplicação não iniciada! use o comando 'php mcquery ini' para criar o arquivo de configuração e instalar dependências.");
}

$config = parse_ini_file("config.ini");
date_default_timezone_set($config['timezone']);
define("URL", $config['URL']);   

require 'Helpers.php';