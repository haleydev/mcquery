<?php
namespace App\Commands;
class Command_Cron_Job
{
    public function cron_start()
    {
        if (strtolower(PHP_OS) == 'linux') {
            if (file_exists(ROOT . '/app/Cache/cron_job.txt')) {
                unlink(ROOT . '/app/Cache/cron_job.txt');
                shell_exec('crontab -r');
                echo "\033[1;31mcron job desativado\033[0m" . PHP_EOL;
            } else {
                $cron = mold_cron_job(ROOT . "/core/Resources/");
                file_put_contents(ROOT . "/app/Cache/cron_job.txt", $cron);

                $file = ROOT . "/app/Cache/cron_job.txt";
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

    public function crontab($job)
    {
        $job_file = mold_crontab($job);
        $msg = "\033[0;32mcronjob $job criado com sucesso ( app/Jobs/Job_" . str_replace(" ", "", $job) . ".php )\033[0m" . PHP_EOL;
        $job = str_replace(" ", "_", $job);

        if (file_exists(ROOT . "/app/Jobs/Job_$job.php")) {
            echo "\033[1;31msubstituir o job '$job' ? (s/n)\033[0m ";
            $console = (string)readline('');
            if ($console == 's') {
                file_put_contents(ROOT . "/app/Jobs/Job_$job.php", $job_file);
                echo $msg;
            } else {
                echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
            }
        } else {
            file_put_contents(ROOT . "/app/Jobs/Job_$job.php", $job_file);
            echo $msg;
        }
    }
}
