<?php
namespace Controllers;
use App\Controller;
use Models\Sitemap;

class SitemapController extends Controller
{   
    public $view = "sitemap";    

    public function sitemap()
    { 
        // $this->query = new Sitemap;
        // $this->query->select();
        
        $this->view("sitemap");
    }    
}