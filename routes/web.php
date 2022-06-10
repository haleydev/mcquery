<?php
use Controllers\{ajaxController, ApiController, HomeController, testController};
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|


Route::url('/', [HomeController::class, 'home'])->name('index');
Route::get('/testes', [testController::class, 'render'])->name('testes');
Route::ajax('/ajax', [ajaxController::class, 'render'])->name('ajax');
Route::api('/api', [ApiController::class, 'api'], 'GET,POST')->name('api');

Route::middleware(['Auth' => 'user'],function(){

    Route::url('/user', function(){
        echo "user";
    })->name('user'); 

    Route::url('/user/{param}', function(){
        echo param('param');
    })->name('user');     
    
});

Route::url('/login', function(){
    echo "login";
})->name('login');   










// --------------------------------------------------------------------------|