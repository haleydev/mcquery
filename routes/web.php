<?php
use Controllers\{admController, formController, HomeController, testController, userController};
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|

Route::get('/',[HomeController::class,'home'])->name('index');
Route::get('/testes',[testController::class,'render'])->name('testes');
Route::url('/form',[formController::class,'render'])->name('form');

Route::url('/login',function(){
    echo "login";
})->name('login');

Route::url('/param/{id}',function(){
    return dd(param('id'));
})->name('login');


// $_SESSION['user'] = 'user';
// $_SESSION['adm'] = 'adm';
session_destroy();


// Route::session(['user' => 'user','user' => 'adm'],function(){

//     Route::get('/user',[userController::class,'render'])->name('user'); 
//     Route::get('/user/{id}',[userController::class,'allUsers'])->name('all.user'); 

// })->redirect('/login');

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