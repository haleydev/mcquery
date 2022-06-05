<?php
use Controllers\{ajaxController, ApiController, HomeController, testController};
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|

// Route::url('/', [HomeController::class, 'home'])->name('index');

// Route::get('/testes', [testController::class, 'render'])->name('testes');

// Route::ajax('/ajax', [ajaxController::class, 'render'])->name('ajax');

// Route::api('/api', [ApiController::class, 'api'], 'GET,POST')->name('api');

Route::session(['auth' => 'adm'],function(){

    Route::get('/adm', function(){
        echo "adm";
    })->name('adm');  

})->redirect('/login');

Route::session(['auth' => 'user'],function(){

    Route::get('/user', function(){
        echo "user";
    })->name('user');   

})->redirect('/');



Route::session(['auth' => 'testes'],function(){

    Route::get('/teste', function(){
        echo "testes";
    })->name('teste');   

    Route::get('/teste2', function(){
        echo "testes2";
    })->name('teste2');   

})->redirect('/testes');






// --------------------------------------------------------------------------|