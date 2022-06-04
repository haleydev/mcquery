<?php
namespace App\Commands;

class Command_Server
{   
    public function server()
    {
        echo "\033[0;32mservidor de desenvolvimento ativo:\033[0m http://127.0.0.1:8888" . PHP_EOL;
        shell_exec('php -S 127.0.0.1:8888 '.ROOT.'/core/Resources/Server.php');               
    }

    public function port($port)
    {
        if (is_numeric($port)) {
            if (strlen($port) == 4) {
                echo "\033[0;32mServidor de desenvolvimento ativo:\033[0m http://127.0.0.1:$port" . PHP_EOL;
                shell_exec("php -S 127.0.0.1:$port ".ROOT."/core/Resources/Server.php");
            } else {
                echo "\033[1;31ma porta deve conter 4 números\033[0m" . PHP_EOL;
            }
        } else {
            echo "\033[1;31ma porta deve conter apenas números\033[0m" . PHP_EOL;
        }          
    }
}