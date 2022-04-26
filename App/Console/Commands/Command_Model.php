<?php
namespace App\Console\Commands;

class Command_Model
{   
    public function model($model)
    {
        if ($model == "") {
            echo "\033[1;31mnome do model não informado\033[0m" . PHP_EOL;
            return;
        } else {
            if (!preg_match("/^[a-zA-Z _]*$/", $model)) {
                echo "\033[1;31mnome do model inválido\033[0m" . PHP_EOL;
                return;
            }

            $confirm = true;
            if (file_exists("Models/$model.php")) {
                echo "\033[1;31msubstituir model '$model' ? (s/n)\033[0m ";
                $console = (string)readline('');
                if ($console == 's') {
                    $confirm == true;
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    $confirm == false;
                    return;
                }
            }

            if ($confirm == true) {
                $file = mold_model($model);
                file_put_contents('Models/' . strtolower($model) . '.php', $file);  
                shell_exec('composer dumpautoload');               
                echo "\033[0;32mmodel $model criado com sucesso \033[0m" . PHP_EOL;
                return;
            }
        }          
    }
}