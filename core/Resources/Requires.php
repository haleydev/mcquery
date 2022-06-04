<?php
/**
 * Esses arquivos sao necessarios para iniciar algumas funcoes cronjob do mcquery.
 */
define('ROOT',dirname(__DIR__,2)); 
require_once ROOT.'/vendor/autoload.php';   
require_once ROOT."/core/Helpers.php";      
date_default_timezone_set(env('TIMEZONE')); 