<?php
namespace App\Commands;

class Command_Middleware
{   
    public function middleware($middleware)
    {
        if (!preg_match("/^[a-zA-Z _]*$/", $middleware) or $middleware == false) {           
            echo "\033[1;31merro: nome inválido '$middleware'\033[0m" . PHP_EOL;
            die();
        } else {         
            $file = mold_middleware($middleware);
            file_put_contents(ROOT .'/app/Middleware/' . $middleware . '.php', $file);
            if (file_exists(ROOT .'/app/Middleware/' . $middleware . '.php')) {
                echo "\033[0;32mMiddleware $middleware criada com sucesso\033[0m" . PHP_EOL;
            } else {
                echo "\033[1;31merro ao criar Middleware $middleware\033[0m" . PHP_EOL;
            }
           
        }       
    }
}