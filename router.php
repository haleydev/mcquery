<?php
require 'App/bootstrap.php';
use Controllers\{ErrorController, HomeController};

// -------------------------------------------------------------------------

$route->url('/', function () {
    (new HomeController)->render();
})->name('home');






















// -------------------------------------------------------------------------
// a pagina de erro deve ter o nome erro para q o 'mcquery' reconheça.
$route->url('/erro', function () {
    (new ErrorController)->render();    
})->name('erro');

$route->end();