<?php
$dir = dirname(__DIR__,2);
$files = scandir("$dir/app/Jobs");

$scanned_directory = array_diff($files, ['..', '.']);

if(!file_exists("$dir/app/Logs/cronjob.log")){
    file_put_contents("$dir/app/Logs/cronjob.log", "");
}

foreach ($scanned_directory as $cron) {
    shell_exec("php $dir/app/Jobs/$cron >> $dir/app/Logs/cronjob.log 2>&1 &");
}