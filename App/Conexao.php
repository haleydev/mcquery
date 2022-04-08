<?php
namespace App;
use mysqli;
use PDO;
use PDOException;

/**
 * Gerencia as conexões com o banco de dados
 */

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
        $this->database = env('db_database');
        $this->username = env('db_username');
        $this->servername = env('db_servername');
        $this->password = env('db_password');        
    }
    
    /**
     * Cria uma conexão PDO com o banco de dados
     */
    public function pdo()
    {   
        try{
            $this->conect = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);        
        } 
        catch (PDOException $pe){
            $this->error = true;
            // die("Falha na conexao: $this->database : ".$pe->getMessage());       
            return;     
        } 
    } 

    /**
     * Cria uma conexão mysqli com o banco de dados     
     */
    public function mysqli()
    {  
        $this->conect = mysqli_connect($this->servername, $this->username, $this->password, $this->database);  
        if(!$this->conect){
            // die("Falha na conexao" . mysqli_connect_error());
            $this->error = true;
            return;
        }
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function close()
    {
        if($this->conect != null){
            $this->conect = null;
        }
    }
}  
