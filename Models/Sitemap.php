<?php
namespace Models;
use App\Conexao;

class Sitemap
{  
    public $result = null; 
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conexao->pdo();
    } 
    
    public function select()
    {    
        $query = "SELECT * FROM sitemap LIMIT 100";       

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            $this->result = $sql->fetchAll();
        }
        $this->conexao->close();
        return;
    }
}