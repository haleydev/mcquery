<?php
$dir = dirname(__DIR__).'/../App';
$files = scandir("$dir/Jobs");

$scanned_directory = array_diff($files, ['..', '.']);

if(!file_exists("$dir/Logs/cronjob.log")){
    file_put_contents("$dir/Logs/cronjob.log", "");
}

foreach ($scanned_directory as $cron) {
    shell_exec("php $dir/Jobs/$cron >> $dir/Logs/cronjob.log 2>&1 &");
}