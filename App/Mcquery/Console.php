<?php
if(file_exists("vendor/autoload.php")){
    require 'vendor/autoload.php';
}
if(file_exists(".env")){
    require 'env.php';
}
require 'files.php';
use App\Mcquery\ControllerConsole;

    $string = "";
    foreach($argv as $console){
        $string.= $console. " ";
    }

    $string = rtrim($string, " ");
    
    // functions mcquery
    if($string == "mcquery"){
        if(!file_exists(".env")){
            die(PHP_EOL."\033[1;31mAplicação não iniciada! use o comando 'php mcquery env' para criar o arquivo de configuração e instalar dependências.\033[0m".PHP_EOL.PHP_EOL);                    
        }else{
            (new ControllerConsole)->dashboard();
            return;
        }        
    }

    if(str_contains($string,'mcquery controller:')){        
        (new ControllerConsole)->newController($string);
        return;
    }

    if(str_contains($string,'mcquery model:')){        
        (new ControllerConsole)->newModel($string);
        return;
    }


    if(isset($argv[1])){
        switch ($argv[1]):
            case "conexao":
                (new ControllerConsole)->conexao();return;
                break;

            case "autoload":
                (new ControllerConsole)->autoload();return;
                break;

            case "env":
                $file = init();  
                file_put_contents('.env', $file);
                shell_exec('composer install');
                if(file_exists("README.md")){
                    unlink("README.md");
                }
                if(file_exists("LICENSE")){
                    unlink("LICENSE");
                }
                echo PHP_EOL."\033[0;32mAplicação iniciada com sucesso \033[0m".PHP_EOL.PHP_EOL;
                die();
                break;
                
            default:
               echo PHP_EOL."\033[1;31mComando inválido!\033[0m".PHP_EOL.PHP_EOL;
                die();
               break;
        endswitch;
    }