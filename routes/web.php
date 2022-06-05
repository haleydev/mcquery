<?php
use Controllers\{admController, ajaxController, formController, HomeController, testController, userController};
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|

Route::url('/',[HomeController::class,'home'])->name('index');
Route::get('/testes',[testController::class,'render'])->name('testes');
Route::url('/form',[formController::class,'render'])->name('form');

Route::ajax('/ajax',[ajaxController::class,'render'])->name('ajax');

Route::url('/login',function(){
    echo "login";
})->name('login');

Route::url('/param/{id}',function(){
    return dd(param('id'));
})->name('login');

Route::session('adm',function(){ 

    Route::get('/adm',function(){
        echo "area adm";
    })->name('adm'); 

    Route::get('/adm/{user}',[admController::class,'render'])->name('array');
})->redirect('/');



Route::session('user',function(){ 
    Route::get('/user',[admController::class,'render'])->name('user'); 
    Route::get('/painel',[admController::class,'render'])->name('painel');    
})->redirect('/login');



// --------------------------------------------------------------------------|