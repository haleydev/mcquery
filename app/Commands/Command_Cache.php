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
        if (file_exists(ROOT . '/app/Cache/env.json')) {           
            unlink(ROOT . '/app/Cache/env.json');
            echo "\033[1;31mcache env desativado\033[0m" . PHP_EOL;
        } else {
            if (file_exists(ROOT . '/app/Cache/env.json')) {
                unlink(ROOT . '/app/Cache/env.json');
            }

            $env = (new Env)->env;
            $file = array_filter($env);
            file_put_contents(ROOT . '/app/Cache/env.json',json_encode($file,true));

            if(file_exists(ROOT . '/app/Cache/env.json')){
                echo "\033[0;32mcache env ativado\033[0m" . PHP_EOL;
            }else{               
                echo "\033[1;31merro ao gravar cache do .env\033[0m" . PHP_EOL;
            }   
        }
    }

    public function template_clear()
    { 
        $dir = ROOT . '/app/Cache/template/';
        $old = ROOT . '/app/Cache/templates.json';

        if(strtolower(PHP_OS) == 'linux') {
            if (file_exists($dir)) {
                shell_exec('sudo rm -r ' . $dir);
            }   
    
            if (file_exists($old)) {
                shell_exec('sudo rm ' . $old);
            }
        }else{
            $iterator = new RecursiveDirectoryIterator($dir,FilesystemIterator::SKIP_DOTS);
            $rec_iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
          
            foreach($rec_iterator as $file){ 
                $file->isFile() ? unlink($file->getPathname()) : rmdir($file->getPathname());                           
            } 
          
            rmdir($dir);
            unlink($old);         
        }        

        if (!file_exists($old) and !file_exists($dir)){
            echo "\033[0;32mcache templates limpo\033[0m" . PHP_EOL;
        }else{
            echo "\033[1;31mfalha ao limpar cache (verifique as permiss??es)\033[0m" . PHP_EOL;
        }               
    }
}