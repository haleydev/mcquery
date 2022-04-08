<?php
require 'App/bootstrap.php';
use Controllers\{ErrorController, HomeController, SitemapController};

// -------------------------------------------------------------------------


$router->url("", function(){
    (new HomeController)->render();
})->name('home');

// sitemap dinamico 'pode ser removido caso não seja necessário'
$router->url("sitemap.xml", function(){
    (new SitemapController)->sitemap();
})->name('sitemap');
















// a pagina de erro deve ter o nome error para q o 'mcquery' reconheça
// a url pode ser alterada
$router->url("error", function(){(new ErrorController)->render();})->name('error');

// -------------------------------------------------------------------------

$router->end();