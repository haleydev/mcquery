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






// --------------------------------------------------------------------------|