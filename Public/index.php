<?php
if (!file_exists(dirname(__DIR__)."/./vendor")) {
    die("Aplicação não iniciada, use o comando 'php mcquery' para criar o arquivo de configuração e instalar dependências.");
}

ob_start();

if (!isset($_SESSION)) {
    session_start();
}

require dirname(__DIR__)."/./vendor/autoload.php";
require dirname(__DIR__)."/./Core/Helpers.php";

date_default_timezone_set(env('TIMEZONE'));
define("ROOT", env('APP_URL'));

require dirname(__DIR__)."/./router.php";