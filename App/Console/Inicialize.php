<?php
use App\Console\Console;
require './App/Console/molds.php';

if (file_exists("./vendor") and file_exists(".env")) {
    require_once './vendor/autoload.php';   
    require_once './App/Helpers.php';
    date_default_timezone_set(env('TIMEZONE'));
    $action = false;
} else {
    $action = true;
}

if ($action == true) {
    echo "\033[1;31mAplicação não iniciada, deseja criar o arquivo '.env' e instalar dependências ? (s/n)\033[0m ";
    $console = (string)readline("");
    readline_read_history();

    if ($console == 's') {
        $file = new_env();
        file_put_contents('.env', $file);
        shell_exec('composer install');

        if (file_exists("README.md")) {
            unlink("README.md");
        }

        if (file_exists("LICENSE")) {
            unlink("LICENSE");
        }

        echo "\033[0;32mAplicação iniciada com sucesso\033[0m" . PHP_EOL;
        die();
    } else {
        echo "\033[1;31mOperação cancelada\033[0m" . PHP_EOL;
        die();
    }
} else {
    $console = new Console;
    $console->reader();
}