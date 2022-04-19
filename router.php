<?php
require 'App/bootstrap.php';
use Controllers\{ErrorController, HomeController};
// -------------------------------------------------------------------------

$route->url('/', function () {
    (new HomeController)->render();
})->name('home');

$route->url('/teste', function () {
    view('teste');
})->name('teste');


















// -------------------------------------------------------------------------
// a pagina de erro deve ter o nome error para q o 'mcquery' reconheça.
$route->url('/error', function () {
    (new ErrorController)->render();    
})->name('error');

$route->end();