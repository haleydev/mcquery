<?php
namespace Controllers;
use Core\Controller;
use Core\Http\Response;
use Models\usuarios;

class ApiController extends Controller
{
    public function api()
    {   
        $select = usuarios::select([
            'where' => [
                usuarios::id => 1
            ]
        ]);    

        Response::header('EXAMPLE','mcquery');
        Response::json($select);  
    }
}