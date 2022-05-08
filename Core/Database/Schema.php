<?php
namespace Core\Database;

class Schema
{
    public static function table(string $table, array $coluns)
    {
        $migration = $coluns['migration'];        
        
        // verifica nome da tabela
        if($table == null or $table == ""){
            echo "\033[1;31merro (" . $migration . ") nome da tabela inválido\033[0m" . PHP_EOL;
            die();
        }else{
            if (!preg_match("/^[a-zA-Z _]*$/", $table)) {
                echo "\033[1;31merro (" . $migration . ") nome da tabela inválido\033[0m" . PHP_EOL;
                die();
            }
        }        
        // verifica erros
        if(count($coluns['error']) > 0){
            foreach($coluns['error'] as $error){
                echo "\033[1;31merro (" . $migration . ") $error\033[0m" . PHP_EOL;
            }
            die();
        }

        // verifica se possui alguma coluna
        if(count($coluns['coluns']) == 0){
            echo "\033[1;31merro (" . $migration . ") não possui nenhuma coluna\033[0m" . PHP_EOL;
        }
       
        return (new Migration)->table($table, $coluns);
    }
}