<?php
namespace Controllers;

class HomeController
{
    public function home()
    {         
        $params = [
            'title' => 'MCQUERY' 
        ];    
                
        return template($params)->view('home');
    }
}