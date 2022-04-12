<?php
function new_env()
{
$file = 
'# Configuração de domínio
APP_URL = http://localhost

# fuso horario
timezone = america/sao_paulo

# banco de dados
db_servername = [database_host]
db_database = [database_name]
db_username = [database_username]
db_password = [database_password]


# php mailer smtp
mailer_name = [nome do site]
mailer_response = [noreply@dominio.com]
mailer_host = [smtp.dominio.com]
mailer_port = [587]
mailer_username = [usuario@dominio.com]
mailer_password = [senha do e-mail]';
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

    public function render()
    {
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
    private $database;

    public function __construct()
    {
        $this->database = new Conexao("pdo");
    } 
    
    public function select($id)
    {    
        $query = "SELECT * FROM '.strtolower($string).' where id = '.$t.'$id'.$t.'";       

        $sql = $this->database->instance->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $this->result = $sql->fetchAll();
        }
        $this->database->close();
    }

    public function insert($value1,$value2,$value3)
    {
        $query = 
        "INSERT INTO '.strtolower($string).' (colun1, colun2, colun3)
         VALUES ('.$t.'$value1'.$t.', '.$t.'$value2'.$t.', '.$t.'$value3'.$t.')";
        
        $sql = $this->database->instance->prepare($query);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        }
        $this->database->close();
    }

    public function update($id,$value)
    {
        $query = "UPDATE '.strtolower($string).' SET calun='.$t.'$value'.$t.' where id='.$t.'$id'.$t.'";

        $sql = $this->database->instance->prepare($query);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        } 
        $this->database->close();
    }

    public function delete($id)
    {
        $query = "DELETE FROM '.strtolower($string).' WHERE id='.$t.'$id'.$t.' LIMIT 1";

        $sql = $this->database->instance->prepare($query);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $this->result = true;
        }else{
            return $this->result = false;
        } 
        $this->database->close();
    }
}';
return $file;
}