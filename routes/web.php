<?php
use Controllers\{ajaxController, ApiController, HomeController, testController};
use Core\Http\Request;
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|


Route::url('/', [HomeController::class, 'home'])->name('index');
Route::get('/testes', [testController::class, 'render'])->name('testes');
Route::ajax('/ajax', [ajaxController::class, 'render'])->name('ajax');
Route::api('/api', [ApiController::class, 'api'], 'GET,POST')->name('api');


Route::post('/post', [ApiController::class, 'api'])->name('post');

Route::middleware(['Auth' => 'user'],function(){

    Route::url('/user', function(){
        echo "user";
    })->name('user'); 

    Route::url('/user/{param}', function(){
        echo param('param');
    })->name('user');     
    
});

Route::url('/file', function(){


})->name('file');  

Route::url('/login', function(){
    $_SESSION['user'] = 'user'; 
    $_SESSION['adm'] = 'adm'; 
})->name('login');  

Route::url('/logoff', function(){
    session_destroy();
    return Request::redirect('/');
});

// --------------------------------------------------------------------------|