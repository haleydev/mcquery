<?php
namespace Core\Model;
use Core\Conexao;
use PDO;
use PDOException;

class Query
{
    private $table;
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conexao->pdo();

        if ($this->conexao->error) {
            die('falha na conexão com o banco de dados'.PHP_EOL);          
        }
    }  

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function query(string $query,array $bindparams = [])
    {
        try {
            $sql = $this->conexao->instance->prepare($query);

            if(count($bindparams) > 0) {
                $count = 1;
                foreach ($bindparams as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            } 

            $sql->execute();
            $this->conexao->close();              
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            if($result) {
               return $result;
            }
          
            return false;
                    
        } catch (PDOException $error) {
            $this->conexao->close(); 
            return $error->getMessage();
        }        
    }

    public function select(string $query, array $bindparams)
    {
        try {
            $sql = $this->conexao->instance->prepare($query);            
            $count = 1;  

            if (isset($bindparams['where'])) {                
                foreach ($bindparams['where'] as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            }

            if (isset($bindparams['like'])) {              
                foreach ($bindparams['like'] as $value) {
                    $sql->bindValue($count, "$value");
                    $count++;
                }
            }

            $sql->execute();
            $this->conexao->close();
           
            if($sql->rowCount() > 0){
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $this->conexao->close(); 
                return null;
            }           
        } catch (PDOException $error) {
            $this->conexao->close();
            return $error->getMessage();
        }
    }

    public function selectOne(string $query, array $bindparams)
    {
        try {
            $sql = $this->conexao->instance->prepare($query);            
            $count = 1;  

            if (isset($bindparams['where'])) {                
                foreach ($bindparams['where'] as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            }

            if (isset($bindparams['like'])) {              
                foreach ($bindparams['like'] as $value) {
                    $sql->bindValue($count, "%$value%");
                    $count++;
                }
            }

            $sql->execute();
            $this->conexao->close();
           
            if($sql->rowCount() > 0){
                return $sql->fetch(PDO::FETCH_ASSOC);
            }else{
                return null;
            }           
        } catch (PDOException $error) {
            $this->conexao->close(); 
            return $error->getMessage();
        }
    }

    public function insert(string $query, array $bindparams)
    { 
        try {
            $sql = $this->conexao->instance->prepare($query);
            $count = 1;
            foreach ($bindparams['insert'] as $value) {
                $sql->bindValue($count, $value);
                $count++;
            }

            $sql->execute();
            $this->conexao->close();

            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $error) {
            $this->conexao->close();
            return false;

            // erro desabilitado retornando apenas false
            // return $error->getMessage();
        }
    }

    public function update(string $query, array $bindparams)
    {  
        try {
            $sql = $this->conexao->instance->prepare($query);    

            $count = 1; 
            
            if (isset($bindparams['update'])) {              
                foreach ($bindparams['update'] as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            }   

            if (isset($bindparams['where'])) {                
                foreach ($bindparams['where'] as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            }                   

            $sql->execute();
            $this->conexao->close();

            if ($sql->rowCount() > 0) {
                return $sql->rowCount();
            } else {
                return false;
            }
        } catch (PDOException $error) {
            $this->conexao->close();
            return $error->getMessage();
        }
     
    }

    public function delete(string $query, array $bindparams)
    {
        try {
            $sql = $this->conexao->instance->prepare($query);            
            $count = 1;  

            if (isset($bindparams['where'])) {                
                foreach ($bindparams['where'] as $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }
            }

            $sql->execute();
            $this->conexao->close();

            if ($sql->rowCount() > 0) {
                return $sql->rowCount();
            } else {
                return false;
            }
        } catch (PDOException $error) {
            $this->conexao->close();
            return $error->getMessage();
        }
    }
}
