<?php
use Core\Router\Route;

class Bootstrap
{
    private bool $error = false;

    public function __construct()
    { 
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);

        define('ROOT',dirname(__DIR__));     
        
        if (!file_exists(ROOT. '/.env') or !file_exists(ROOT. '/vendor')) {
            $this->error = true;
        }else{       
            require_once ROOT . '/vendor/autoload.php';
            require_once ROOT . '/core/Helpers.php';
            date_default_timezone_set(env('TIMEZONE'));
        }        
    }    

    public function app()
    {
        if ($this->error) {           
            die("Aplicação não iniciada, use o comando 'php mcquery' para criar o arquivo de configuração e instalar dependências.");
        }  

        ob_start(); 

        if (!isset($_SESSION)) {
            session_start();
        }

        define("URL", env('APP_URL'));
        require_once ROOT . '/routes/web.php';  
        Route::end();     
    }

    public function console()
    {        
        require ROOT.'/core/Resources/Molds.php';
        if ($this->error) {
            echo "\033[1;31maplicação não iniciada, deseja criar o arquivo '.env' e instalar dependências ? (s/n)\033[0m "; 
            $console = (string)readline("");
            readline_read_history();
        
            if ($console == 's') {
                if((float)phpversion() < 8.0) {
                    echo "\033[1;31mversão minima necessária 8.0.2 sua versão atual do php: ". phpversion() ."\033[0m " . PHP_EOL; 
                    die();
                }

                $file = mold_env();
                file_put_contents(ROOT.'/.env', $file);
                shell_exec('composer install');

                if (strtolower(PHP_OS) == 'linux'){
                    shell_exec('sudo chmod -R a+rw ' . ROOT);
                }              
        
                if (file_exists(ROOT."/README.md")) {
                    unlink(ROOT."/README.md");
                }
        
                if (file_exists(ROOT."/LICENSE")) {
                    unlink(ROOT."/LICENSE");
                }

                if(file_exists(ROOT. '/.env') and file_exists(ROOT. '/vendor')) {
                    echo "\033[0;32maplicação iniciada com sucesso\033[0m" . PHP_EOL;
                    die();
                }else{
                    echo "\033[1;31merro ao iniciar o mcquery, verifique as permissões\033[0m" . PHP_EOL;
                    die();                    
                }
            } else {
                echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                die();
            }
        } else {
            require_once ROOT . '/routes/console.php';
            (new console)->commands();            
        }    
    }    

    public function __destruct()
    {        
        while (ob_get_level() > 0) {
           ob_end_flush();
        }   
              
        die();        
    }
}