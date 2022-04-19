<?php
require 'App/bootstrap.php';
use Controllers\{ErrorController, HomeController};
// -------------------------------------------------------------------------

$route->url('/', function () {
    (new HomeController)->render();
})->name('home');






















// -------------------------------------------------------------------------
// a pagina de erro deve ter o nome 404 para q o 'mcquery' reconheça.
$route->url('/404', function () {
    (new ErrorController)->render();    
})->name('error');

$route->end();