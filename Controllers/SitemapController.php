<?php
namespace Controllers;
use App\Controller;

class SitemapController extends Controller
{   
    public $view = "sitemap";    

    public function sitemap(){ 
        // $this->query(["SELECT * FROM sitemap ORDER BY id DESC"]);   
        $this->view("sitemap");
    }    
}