<?php
namespace Controllers;
use Core\Http\Response;

class ajaxController
{
    public function render()
    {  
        return Response::json(request()->all()); 
    }
}