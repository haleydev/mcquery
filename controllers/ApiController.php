<?php
namespace Controllers;
use Core\Controller;

class ApiController extends Controller
{
    public function api()
    { 
        $info = [
            get('name') => 'helo api'
        ];
    
        print_r(json_encode($info));   
        return; 
    }
}