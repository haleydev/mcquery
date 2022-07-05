<?php

use App\Middleware\Auth;
use Controllers\{ajaxController, ApiController, database, HomeController, testController};
use Core\Router\Route;

// --------------------------------------------------------------------------|
//                            ROUTER MCQUERY                                 |
// --------------------------------------------------------------------------|


Route::url('/', [HomeController::class, 'home'])->name('home');
Route::post('/post', [ApiController::class, 'api'])->name('post');
Route::ajax('/ajax', [ajaxController::class, 'render'])->name('ajax');
Route::api('/api', [ApiController::class, 'api'], 'GET,POST')->name('api');
Route::get('/data',[database::class, 'render'])->name('database');

Route::get('/testes', [testController::class, 'testes'])->name('testes');

Route::middleware(['Auth' => 'user'],function(){

    Route::url('/user', function(){
        echo "user";
    })->name('user'); 

    Route::url('/user/{param}', function(){
        echo param('param');
    })->name('user.param');         
});

Route::middleware(['Headers' => 'json'],function(){
    Route::get('/file/{file}', function(){

        // dd(request()->param('file'));
        dd(request()->all());
        dd(redirect()->route('home'));
        
     })->name('file');      
});

Route::url('/haley', function(){
    return redirect('/');
})->name('haley');  


Route::url('/login', function(){
    
    if(isset($_SESSION['user']) or isset($_SESSION['adm'])) {
        return redirect()->route('user');
    }

    $_SESSION['user'] = 'user'; 
    $_SESSION['adm'] = 'adm'; 

    return redirect()->route('user');

})->name('login');  

Route::url('/logoff', function(){
    session_destroy();
    return redirect();
});

// --------------------------------------------------------------------------|