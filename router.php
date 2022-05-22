<?php
$route = new Core\Router;
use Controllers\{ajaxController, HomeController, testController};

//--------------------------------------------------------------------------|
//                            MCQUERY ROUTES                                |
//--------------------------------------------------------------------------|

$route->url('/', [HomeController::class, 'render'])->name('home');

$route->url('/formulario', [testController::class, 'render'])->name('formulario');

$route->post('/login', [testController::class, 'login'])->name('login');

$route->post('/delete', [testController::class, 'delete'])->name('userdelete');

$route->ajax('/pesquisa',[testController::class, 'pesquisa'])->name('pesquisa');

$route->ajax('/ajax',function(){
    return (new ajaxController)->addCart();
})->name('ajax');

$route->get('/validate',function(){
    return template('views/validate');
})->name('validate');

$route->post('/validate',[])->name('validate');












//---------------------------------------------------------------------------