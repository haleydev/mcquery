<?php
namespace App\Console\Commands;
use Core\Database\Migration;

class Command_Drop
{   
    public function drop_table(string $table)
    {
        if (!preg_match("/^[a-zA-Z _]*$/", $table)) {
            echo "\033[1;31mnome da tabela inválido\033[0m" . PHP_EOL;
            die();
        } else {
            echo "\033[1;31mexcluir tabela '$table' ? (s/n)\033[0m ";
            $console = (string)readline('');
            if ($console == 's') {
                (new Migration)->console_drop($table);
            } else {
                echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                die();
            }
        }  
    }
}