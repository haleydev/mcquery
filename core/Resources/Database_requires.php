<?php
define('ROOT',dirname(__DIR__,2)); 
use Core\Database\DataTypes;
require ROOT."/vendor/autoload.php";
$table = new DataTypes;