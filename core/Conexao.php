<?php
namespace Core;

use PDO;
use PDOException;
use mysqli_sql_exception;

/**
 * Gerencia as conexões com o banco de dados.
 */

class Conexao
{
    private $database;
    private $username;
    private $servername;
    private $port;
    private $password;
    private $drive;
    private $method = null;

    /**
     * Conecta a query ao banco de dados.
     */
    public $instance = null;

    /**
     * Retorna true se não conseguir conectar ao banco de dados.
     * Retorna false se conseguir conectar ao banco de dados.
     * @return true|false
     */
    public $error = false;

    public function __construct()
    {
        $env = new Env;
        $this->database = $env->env['DB_DATABASE'];
        $this->port = $env->env['DB_PORT'];
        $this->username = $env->env['DB_USERNAME'];
        $this->servername = $env->env['DB_SERVER'];
        $this->password = $env->env['DB_PASSWORD'];
        $this->drive = $env->env['DB_CONNECTION'];
    }

    /**
     * Cria uma conexão PDO com o banco de dados.
     */
    public function pdo()
    {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            $this->instance = new PDO("$this->drive:host=$this->servername;port=$this->port;dbname=$this->database", $this->username, $this->password, $options);
            $this->method = "pdo";
            return;
        } catch (PDOException $e) {
            // Registra o log de erro            
            file_put_contents(dirname(__DIR__) . "/app/Logs/conexao.log", "[" . date('d/m/Y h:i:s') . "] " . $e->getMessage() . PHP_EOL, FILE_APPEND);

            $this->error = true;
            // die("Falha na conexao");       
            return;
        }
    }

    /**
     * Cria uma conexão mysqli com o banco de dados.    
     */
    public function mysqli()
    {
        try {
            $this->instance = mysqli_connect($this->servername . ':' . $this->port, $this->username, $this->password, $this->database);
            $this->method = "mysqli";
            return;
        } catch (mysqli_sql_exception $e) {
            // Registra o log de erro            
            file_put_contents(dirname(__DIR__) . "/app/Logs/conexao.log", "[" . date('d/m/Y h:i:s') . "] " . $e->getMessage() . PHP_EOL, FILE_APPEND);

            $this->error = true;
            // die("Falha na conexao");           
            return;
        }
    }

    /**
     * Fecha a conexão com o banco de dados.
     */
    public function close()
    {
        if ($this->method != null and $this->instance != null) {
            switch ($this->method):
                case "pdo":
                    $this->instance = null;
                    break;
                case "mysqli":
                    mysqli_close($this->instance);
                    $this->instance = null;
                    break;
            endswitch;
        }

        return;
    }
}
