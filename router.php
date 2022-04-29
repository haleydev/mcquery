<?php
$route = new App\Router;
use Controllers\{HomeController, TesteController};

//--------------------------------------------------------------------------|
//                            MCQUERY ROUTES                                |
//--------------------------------------------------------------------------|

$route->url('/', [HomeController::class, 'render'])->name('home');

$route->get('/teste',[TesteController::class, 'render'])->name('teste');

















//---------------------------------------------------------------------------