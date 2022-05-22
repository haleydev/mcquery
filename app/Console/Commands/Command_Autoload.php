<?php
namespace App\Console\Commands;

class Command_Autoload
{   
    public function autoload()
    {
        shell_exec('composer dumpautoload');  
        echo "\033[0;32mautoload de classes atualizado\033[0m" . PHP_EOL;           
    }
}