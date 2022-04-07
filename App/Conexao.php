<?php
namespace App;
use mysqli;
use PDO;
use PDOException;

class Conexao
{  
    private $database;
    private $username;
    private $servername;
    private $password;

    public $conect = null;
    public $error = false;
  

    public function __construct()
    {
        $config = parse_ini_file("config.ini");
        $this->database = $config['db_database'];
        $this->username = $config['db_username'];
        $this->servername = $config['db_servername'];
        $this->password = $config['db_password'];        
    }

    public function pdo(){   
        try{
            $this->conect = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);        
        } 
        catch (PDOException $pe){
            $this->error = true;
            // die("Falha na conexao: $this->database : ".$pe->getMessage());       
            return;     
        } 
    } 

    public function mysqli(){  
        $this->conect = mysqli_connect($this->servername, $this->username, $this->password, $this->database);  
        if(!$this->conect){
            // die("Falha na conexao" . mysqli_connect_error());
            $this->error = true;
            return;
        }
      }

    public function close(){
        if($this->conect != null){
            $this->conect = null;
        }
    }
}  
