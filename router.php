<?php
require 'App/bootstrap.php';
require 'vendor/autoload.php';
use App\System;
use Controllers\{ErrorController, HomeController, SitemapController};
$app = new System; 

// -------------------------------------------------------------------------

$app->url("", function(){(new HomeController)->render();})->name('home');

// sitemap dinamico 'pode ser removido caso não seja necessário'
$app->url("sitemap.xml", function(){(new SitemapController)->sitemap();})->name('sitemap');















// a pagina de erro deve ter o nome error para q o 'mcquery' reconheça
// a url pode ser alterada
$app->url("error", function(){(new ErrorController)->render();})->name('error');

// -------------------------------------------------------------------------

$app->end();