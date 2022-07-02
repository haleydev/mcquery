<?php
namespace App\Commands;
use Core\Env;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Command_Cache
{
    public function cache_env()
    {
        if (file_exists(ROOT . '/app/Cache/env.php')) {           
            unlink(ROOT . '/app/Cache/env.php');
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

    public function template_clear()
    { 
        $dir = ROOT . '/app/Cache/template/';
        $old = ROOT . '/app/Cache/old_template.json';

        if(strtolower(PHP_OS) == 'linux') {
            if (file_exists($dir)) {
                shell_exec('sudo rm -r ' . $dir);
            }   
    
            if (file_exists($old)) {
                shell_exec('sudo rm ' . $old);
            }
        }else{
            if (file_exists($dir)) {
                $directory_iterator = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
                $iterator = new RecursiveIteratorIterator($directory_iterator);
                 
                foreach ($iterator as $file) {
                   unlink(strval($file));                       
                } 
            }   
    
            if (file_exists($old)) {
                unlink($old);
            }
        }        

        if (!file_exists($old) and !file_exists($dir)){
            echo "\033[0;32mcache templates limpo\033[0m" . PHP_EOL;
        }else{
            echo "\033[1;31mfalha ao limpar cache (verifique as permissões)\033[0m" . PHP_EOL;
        }               
    }
}