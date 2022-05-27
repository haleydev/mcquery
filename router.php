<?php
$route = new Core\Router;
use Controllers\{formController, HomeController, postController, testController};
use Core\Http\Request;

//--------------------------------------------------------------------------|
//                            MCQUERY ROUTES                                |
//--------------------------------------------------------------------------|

echo Request::url();

$route->url('/', [HomeController::class, 'render'])->name('home');

$route->get('/testes/{teste}', [testController::class, 'render'])->name('testes');

$route->ajax('/post', [postController::class, 'render'])->name('post');

$route->get('/form',[formController::class, 'render'])->name('form');


// $route->api('/form',function(){
//     return (new ApiController)->api();   
// },'get,post')->name('api');






//---------------------------------------------------------------------------