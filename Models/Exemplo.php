<?php
namespace Models;
use App\Conexao;

class Exemplo
{  
    public $result = null; 
    private $conexao;

    public function __construct(){
        $this->conexao = new Conexao;
        $this->conexao->pdo();
    } 
    
    public function select($id){    
        $query = "SELECT * FROM exemplo where id = '$id'";       

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $this->result = $sql->fetchAll();
        }
        $this->conexao->close();
    }

    public function insert($value1,$value2,$value3){
        $query = 
        "INSERT INTO exemplo (colun1, colun2, colun3)
         VALUES ('$value1', '$value2', '$value3')";
        
        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        }
        $this->conexao->close();
    }

    public function update($id,$value){
        $query = "UPDATE exemplo SET calun='$value' where id='$id'";

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        } 
        $this->conexao->close();
    }

    public function delete($id){
        $query = "DELETE FROM exemplo WHERE id='$id' LIMIT 1";

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        } 
        $this->conexao->close();
    }
}