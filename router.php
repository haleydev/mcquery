<?php
$route = new Core\Router;
use Controllers\{HomeController, testController};

//--------------------------------------------------------------------------|
//                            MCQUERY ROUTES                                |
//--------------------------------------------------------------------------|

$route->url('/', [HomeController::class, 'render'])->name('home');

$route->url('/formulario', [testController::class, 'render'])->name('formulario');

$route->post('/login', [testController::class, 'login'])->name('login');

$route->ajax('/pesquisa',[testController::class, 'pesquisa'])->name('pesquisa');


















//---------------------------------------------------------------------------