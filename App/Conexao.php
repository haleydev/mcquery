<?php
namespace App;

use PDO;
use PDOException;
use mysqli_sql_exception;

/**
 * Gerencia as conexões com o banco de dados
 */

class Conexao
{  
    private $database;
    private $username;
    private $servername;
    private $password;
    private $drive = null;


    /**
     * Conecta a query ao banco de dados
     */
    public $conect = null;    

    /**
     * Retorna true se não conseguir conectar ao banco de dados
     * @return true|false
     */
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
            $this->drive = "pdo";   
            return;
        } 
        catch(PDOException $pe){
            $this->error = true;
            // die("Falha na conexao: ".$pe->getMessage());       
            return;     
        }
    } 

    /**
     * Cria uma conexão mysqli com o banco de dados     
     */
    public function mysqli()
    {          
        try{
            $this->conect = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
            $this->drive = "mysqli"; 
            return;
        }
        catch(mysqli_sql_exception){           
            $this->error = true;           
            // die("Falha na conexao: ". mysqli_connect_error());           
            return;
        }
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function close()
    {
        if($this->drive != null and $this->conect != null){
            if($this->drive == "pdo"){
                $this->conect = null;
            }

            if($this->drive == "mysqli"){
                mysqli_close($this->conect);
            }
        }

        return;
    }
}