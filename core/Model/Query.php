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
                    $sql->bindValue($count, "%$value%");
                    $count++;
                }
            }

            $sql->execute();
            $this->conexao->close();
           
            if($sql->rowCount() > 0){
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return null;
            }           
        } catch (PDOException $error) {
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
            return $error->getMessage();
        }
    }

    public function insert(array $arguments)
    {
        $values = "";
        $coluns = "";
        $i = 1;
        $total = count($arguments);
        foreach ($arguments as $key => $value) {
            if ($i < $total) {
                $v = ", ";
            } else {
                $v = "";
            }
            $coluns .= "$key$v";
            $values .= " ? $v";
            $i++;
        }

        $query = "INSERT INTO $this->table ( $coluns ) VALUES ( $values )";

        try {
            $sql = $this->conexao->instance->prepare($query);
            $count = 1;
            foreach ($arguments as $key => $value) {
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
        } catch (PDOException) {
            return false;
        }
    }

    public function update(array $arguments)
    {
        if (isset($arguments['update'])) {
            if (isset($arguments['where'])) {
                $where = $this->where($arguments['where']);
            } else {
                $where = "";
            }

            $values = "";
            $i = 1;
            $total = count($arguments['update']);
            foreach ($arguments['update'] as $key => $value) {
                if ($i < $total) {
                    $v = " , ";
                } else {
                    $v = "";
                }
                $values .= "$key = ?$v";
                $i++;
            }

            if (isset($arguments['limit'])) {
                $limit = "LIMIT " . $arguments['limit'];
            } else {
                $limit = "";
            }

            $query = "UPDATE $this->table SET $values $where $limit";

            try {
                $sql = $this->conexao->instance->prepare($query);

                $count = 1;
                foreach ($arguments['update'] as $key => $value) {
                    $sql->bindValue($count, $value);
                    $count++;
                }

                if (isset($arguments['where'])) {
                    foreach ($arguments['where'] as $key => $value) {
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
            } catch (PDOException) {
                return false;
            }
        }else{
            return false;
        }
    }

    public function delete(array $arguments = null)
    {
        if (isset($arguments['where'])) {
            $where = $this->where($arguments['where']);
        } else {
            $where = "";
        }

        if (isset($arguments['limit'])) {
            $limit = "LIMIT " . $arguments['limit'];
        } else {
            $limit = "";
        }

        $query = "DELETE FROM $this->table $where $limit";

        try {
            $sql = $this->conexao->instance->prepare($query);
            if (isset($arguments['where'])) {
                $count = 1;
                foreach ($arguments['where'] as $key => $value) {
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
        } catch (PDOException) {
            return false;
        }
    }

    // funcoes privadas
    private function join($join)
    {
        $joins = explode(',', trim($join), 2);
        $string = "";
        foreach ($joins as $j) {
            $array = explode('=', trim($j), 2);
            $table =  explode('.', trim($array[1]), 2)[0];
            $string .= "RIGHT JOIN $table ON $this->table.$array[0] = $array[1]";
        }
        return trim($string);
    }

    private function where_like($where_like)
    {
        $new_string = "";
        $count = count($where_like);
        $for_count = 1;
        foreach ($where_like as $key => $like) {
            if ($count > $for_count) {
                $and = " OR";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $wh = "WHERE";
            } else {
                $wh = "";
            }

            $new_string .= "$wh $key LIKE ? $and";
            $for_count++;
        }
        return $new_string;
    }

    private function where($where)
    {
        $new_string = "";
        $count = count($where);
        $for_count = 1;
        foreach ($where as $key => $alter) {
            if ($count > $for_count) {
                $and = " AND";
            } else {
                $and = "";
            }

            if ($for_count == 1) {
                $wh = " WHERE";
            } else {
                $wh = "";
            }

            $new_string .= "$wh $key = ? $and";
            $for_count++;
        }
        return $new_string;
    }
}
