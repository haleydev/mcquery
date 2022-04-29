<?php
namespace App\Console\Commands;

class Command_Cron_Job
{
    public function cron_job()
    {
        if (strtolower(PHP_OS) == 'linux') {
            if (file_exists('App/cache/cron_job.txt')) {
                unlink('App/cache/cron_job.txt');
                shell_exec('crontab -r');
                echo "\033[1;31mcron job desativado\033[0m" . PHP_EOL;
            } else {                
                $folder_app = str_replace('/Console', '', dirname(__DIR__));
                $cron = mold_cron_job("$folder_app/Crontab/");
                file_put_contents("$folder_app/cache/cron_job.txt", $cron);

                $file = "$folder_app/cache/cron_job.txt";
                shell_exec('crontab ' . $file);

                $check = shell_exec('crontab -l');

                if (str_contains($check, $cron)) {
                    // cron job pode pedir senha
                    shell_exec('sudo service cron restart');
                    echo "\033[0;32mcron job rodando\033[0m" . PHP_EOL;
                } else {
                    echo "\033[1;31merro ao ativar cronjob 'verifique se o caminho para o mcquery possui pastas com espaços ou caracteres especiais'\033[0m" . PHP_EOL;
                }
            }
        } else {
            echo "\033[1;31mseu sistema operacional não é linux\033[0m" . PHP_EOL;
        }
    }
}