<?php
namespace Models;
use App\Conexao;

class Sitemap
{  
    public $result = null; 
    private $database;

    public function __construct()
    {
        $this->database = new Conexao("pdo");
    } 
    
    public function select()
    {    
        $query = "SELECT * FROM sitemap LIMIT 100";       

        $sql = $this->database->instance->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            $this->result = $sql->fetchAll();
        }
        $this->database->close();
        return;
    }
}