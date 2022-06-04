<?php
namespace App\Commands;

class Command_Install
{   
    public function install()
    {
        shell_exec('composer install');
        echo "\033[0;32mdependências do composer instaladas com sucesso\033[0m" . PHP_EOL;        
    }
}