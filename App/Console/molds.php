<?php
function new_env()
{
$file = 
'APP_NAME = MCQUERY
APP_URL = http://localhost
TIMEZONE = America/Sao_Paulo

DB_CONNECTION = mysql
DB_SERVER = localhost
DB_DATABASE = mcquery
DB_USERNAME = root
DB_PASSWORD = root

MAILER_NAME = nome do remetente
MAILER_RESPONSE = emailderespostas@hotmal.com
MAILER_HOST =
MAILER_PORT =
MAILER_USERNAME =
MAILER_PASSWORD =';
return $file;
}

function controller($string,$namespace = null)
{
$file = 
'<?php
namespace Controllers'.$namespace.';
use App\Controller;

class '.$string.' extends Controller
{        
    public $title = "'.$string.'";
    public $view = "";    

    public function render()
    {
        $this->layout("main");         
    }
}';
return $file;
}

function cacher($array){
$file =
'<?php
$cache = 
'.var_export($array,true).';';
return $file;
}