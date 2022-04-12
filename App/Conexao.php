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
    private $servername;
    private $database;
    private $username;    
    private $password;
    private $driver = null;

    /**
     * Instancia desta conexão, que permite realizar queries no banco de dados conectado.
     */
    public $instance = null;    

    /**
     * Retorna true se não conseguir conectar ao banco de dados.
     * @return true|false
     */
    public $error = false;
    
    /**
     * Retorna a mensagem de erro da conexão, caso aconteca algum erro.
     */
    public $errorMessage = "";
    
    public function __construct($driver)
    {        
        $this->servername = env('db_servername');
        $this->database = env('db_database');
        $this->username = env('db_username');        
        $this->password = env('db_password');
        $this->driver = $driver;  
        $this->connect();
    }

    public function __destruct(){
        $this->close();
    }

    private function connect(){
        switch($this->driver){
            case "pdo":
                return $this->pdo();
            case "mysql":
                return $this->mysqli();
            default: 
                $this->error = true;
                $this->errorMessage = "Invalid driver for connection";
        }
    }
    
    /**
     * Cria uma conexão PDO com o banco de dados
     */
    private function pdo()
    {         
        try{
            $this->instance = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);     
        } 
        catch(PDOException $pe){
            $this->error = true;
            $this->errorMessage = $pe->getMessage();
        }
    } 

    /**
     * Cria uma conexão mysqli com o banco de dados     
     */
    private function mysqli()
    {          
        try{
            $this->instance = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        }
        catch(mysqli_sql_exception){           
            $this->error = true; 
            $this->errorMessage = mysqli_connect_error();
        }
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function close()
    {
        if($this->drive == null || $this->instance == null)
        {
            return;
        }

        $this->error = false;
        $this->errorMessage = "";

        switch($this->driver){
            case "pdo":
                $this->instance = null;
            break;
            case "mysqli":
                mysqli_close($this->instance);
                $this->instance = null;
            break;
        }
    }
}