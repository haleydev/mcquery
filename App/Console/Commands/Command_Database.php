<?php
namespace App\Console\Commands;
use Core\Database\Migration;

class Command_Database
{   
    public function database($database)
    {
        if (!preg_match("/^[a-zA-Z _]*$/", $database)) {
            echo "\033[1;31merro: nome inválido '$database'\033[0m" . PHP_EOL;
            die();
        } else {
            (new Migration)->new_database(str_replace(" ","_",trim($database)));
        }       
    }
}