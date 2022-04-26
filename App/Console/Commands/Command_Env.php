<?php
namespace App\Console\Commands;

class Command_Env
{   
    public function env()
    {
        if (file_exists('.env')) {
            echo "\033[1;31msubstituir o .env atual ? (s/n)\033[0m ";
            $console_env = (string)readline('');
            if ($console_env == 's') {
                $this->new_env();
            } else {
                echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                die();
            }
        } else {
            $this->new_env();
        }       
    }

    private function new_env()
    {
        $file = mold_env();
        file_put_contents('.env', $file);
        if (file_exists('.env')) {
            echo "\033[0;32m.env criado com sucesso \033[0m" . PHP_EOL;
            die();
        } else {
            echo "\033[1;31mfalha ao criar .env\033[0m" . PHP_EOL;
        }
    }
}