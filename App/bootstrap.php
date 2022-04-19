<?php
if (!file_exists("./vendor")) {
    die("Aplicação não iniciada, use o comando 'php mcquery' para criar o arquivo de configuração e instalar dependências.");
}

if (!isset($_SESSION)) {
    session_start();
}

ob_start();

require 'vendor/autoload.php';
require 'Helpers.php';

date_default_timezone_set(env('TIMEZONE'));
define("ROOT", env('APP_URL'));

use App\Router;
$route = new Router;