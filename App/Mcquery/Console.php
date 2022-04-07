<?php
if(file_exists("vendor/autoload.php")){
    require 'vendor/autoload.php';
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
        (new ControllerConsole)->dashboard();
        return;
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

            case "config":
                $file = init();  
                file_put_contents('config.ini', $file);
                shell_exec('composer install');
                echo PHP_EOL."\033[0;32mAplicação iniciada com sucesso \033[0m".PHP_EOL.PHP_EOL;
                die();
                break;
                
            default:
               echo PHP_EOL."\033[1;31mComando inválido!\033[0m".PHP_EOL.PHP_EOL;
                die();
               break;
        endswitch;
    }