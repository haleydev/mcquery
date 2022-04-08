<?php
function init()
{
$file = 
'# comfiguracao de dominio
URL = http://localhost

# fuso horario
timezone = america/sao_paulo

# banco de dados
db_database = phpmyadmin
db_username = root
db_servername = localhost
db_password =

# php mailer smtp
mailer_name = nome do remetente
mailer_response = emailderespostas@hotmal.com
mailer_host =
mailer_port =
mailer_username =
mailer_password =';
return $file;
}

function controller($string,$namespace = null)
{
$file = 
'<?php
namespace Controllers'.$namespace.';
use App\Controller;

class '.$string.' extends Controller
{        
    public $title = "'.$string.'";
    public $view = "";    

    public function render(){
        $this->layout("main");         
    }
}';
return $file;
}

function model($string)
{
$t = "'";
$file =
'<?php
namespace Models;
use App\Conexao;

class '.$string.'
{  
    public $result = null; 
    private $conexao;

    public function __construct(){
        $this->conexao = new Conexao;
        $this->conexao->pdo();
    } 
    
    public function select($id){    
        $query = "SELECT * FROM '.strtolower($string).' where id = '.$t.'$id'.$t.'";       

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $this->result = $sql->fetchAll();
        }
        $this->conexao->close();
    }

    public function insert($value1,$value2,$value3){
        $query = 
        "INSERT INTO '.strtolower($string).' (colun1, colun2, colun3)
         VALUES ('.$t.'$value1'.$t.', '.$t.'$value2'.$t.', '.$t.'$value3'.$t.')";
        
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
        $query = "UPDATE '.strtolower($string).' SET calun='.$t.'$value'.$t.' where id='.$t.'$id'.$t.'";

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
        $query = "DELETE FROM '.strtolower($string).' WHERE id='.$t.'$id'.$t.' LIMIT 1";

        $sql = $this->conexao->conect->prepare($query);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        } 
        $this->conexao->close();
    }
}';
return $file;
}