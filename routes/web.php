<?php
use Controllers\{ajaxController, ApiController, database, HomeController, testController};
use Core\Http\Request;
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|

Route::url('/', [HomeController::class, 'home'])->name('index');
Route::get('/testes', [testController::class, 'render'])->name('testes');
Route::post('/post', [ApiController::class, 'api'])->name('post');
Route::ajax('/ajax', [ajaxController::class, 'render'])->name('ajax');
Route::api('/api', [ApiController::class, 'api'], 'GET,POST')->name('api');
Route::get('/data',[data::class, 'render'])->name('database');

Route::middleware(['Auth' => 'user'],function(){

    Route::url('/user', function(){
        echo "user";
    })->name('user'); 

    Route::url('/user/{param}', function(){
        echo param('param');
    })->name('user.param');         
});

Route::url('/file', function(){


})->name('file');  

Route::url('/login', function(){
    
    if(isset($_SESSION['user']) or isset($_SESSION['adm'])) {
        return Request::redirect(route('user'));
    }

    $_SESSION['user'] = 'user'; 
    $_SESSION['adm'] = 'adm'; 

    return Request::redirect(route('user'));

})->name('login');  

Route::url('/logoff', function(){
    session_destroy();
    return Request::redirect('/');
});

// --------------------------------------------------------------------------|