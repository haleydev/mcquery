<?php
require_once  dirname(__DIR__)."/../vendor/autoload.php";   
require_once dirname(__DIR__)."/Helpers.php";      
date_default_timezone_set(env('TIMEZONE')); 
require_once dirname(__DIR__)."/CronJob.php";
$schedule->execute();