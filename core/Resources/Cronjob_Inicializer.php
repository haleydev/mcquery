<?php
define('ROOT',dirname(__DIR__,2));    
$files = scandir(ROOT . "/app/Jobs");
$scanned_directory = array_diff($files, ['..', '.']);

if(!file_exists(ROOT . "/app/Logs/cronjob.log")){
    file_put_contents(ROOT . "/app/Logs/cronjob.log", "");
}

foreach ($scanned_directory as $cron) {
    shell_exec("php " .  ROOT . "/app/Jobs/$cron >> " . ROOT . "/app/Logs/cronjob.log 2>&1 &");
}