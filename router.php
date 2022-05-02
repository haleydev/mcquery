<?php
$route = new Core\Router;
use Controllers\{HomeController, TestController};

//--------------------------------------------------------------------------|
//                            MCQUERY ROUTES                                |
//--------------------------------------------------------------------------|

$route->url('/', [HomeController::class, 'render'])->name('home');

$route->get('/test',[TestController::class, 'render'])->name('test');











//---------------------------------------------------------------------------