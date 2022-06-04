<?php
namespace App\Commands;
use Core\Env;

class Command_Cache
{
    public function cache_env()
    {
        if (file_exists(ROOT . '/app/Cache/env.php')) {
            unlink(ROOT . 'app/Cache/env.php');
            echo "\033[1;31mcache env desativado\033[0m" . PHP_EOL;
        } else {
            if (file_exists(ROOT . '/app/Cache/env.php')) {
                unlink(ROOT . '/app/Cache/env.php');
            }

            $env = (new Env)->env;
            $file = mold_env_cacher(array_filter($env));
            file_put_contents(ROOT . '/app/Cache/env.php', $file);
            echo "\033[0;32mcache env ativado\033[0m" . PHP_EOL;
        }
    }
}