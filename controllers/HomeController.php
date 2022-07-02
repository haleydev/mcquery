<?php
namespace Controllers;
use Core\Controller;

class HomeController extends Controller
{
    public function home()
    {   
        $return = [
            'title' => 'haley aaa' 
        ];     
                    
        return template('views/home',$return); 
    }
}