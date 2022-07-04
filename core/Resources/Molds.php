<?php
function mold_middleware($class)
{
$mold =
'<?php
namespace App\Middleware;
use Core\Router\Middleware;

class '.$class.'
{
    public function example(Middleware $middleware)
    {
        if (isset($_SESSION[\'example\'])) {
            return $middleware->continue();         
        }

        return $middleware->denied();
    }
}';
return $mold; 
}
function mold_env()
{
$mold = 
'APP_NAME = MCQUERY
APP_URL = automatic
TIMEZONE = America/Sao_Paulo

DB_CONNECTION = mysql
DB_SERVER = localhost
DB_PORT = 3306
DB_DATABASE = mcquery
DB_USERNAME = root
DB_PASSWORD = root

MAILER_NAME = nome do remetente
MAILER_RESPONSE = emailderespostas@hotmal.com
MAILER_HOST =
MAILER_PORT =
MAILER_USERNAME =
MAILER_PASSWORD =';
return $mold;
}

function mold_controller($string, $namespace = null)
{
$mold =
'<?php
namespace Controllers'.$namespace.';

class '.$string.'
{
    public function render()
    {  
        //...

        return template()->view(\'example\'); 
    }
}';
return $mold;
}

function mold_class($string, $namespace = null)
{
$mold =
'<?php
namespace App\Classes'.$namespace.';

class '.$string.'
{
    public function '.$string.'()
    { 
       //... 
    }
}';
return $mold;
}

function mold_migrate($name){
$mold=
'<?php
use Core\Database\Schema;
require "./core/Resources/Database_requires.php";

$table->id();
$table->string(\'nome\',100);
$table->string(\'sobrenome\', 100);
$table->string(\'email\'); 
$table->string(\'password\',100);
$table->int(\'idade\');    
$table->edited_dt();
$table->created_dt();
  
Schema::table(\''.$name.'\',$table->migrate());';
return $mold;
}

function mold_model($model,$coluns)
{
$mold =
'<?php
namespace Models;
use Core\Model\DB;
use Core\Model\Model;

class '. $model .' implements Model
{ 
    private static string $table = \''. $model .'\';
    
    '. $coluns .'
    public static function select()
    {
        return DB::select(self::$table);        
    }

    public static function selectOne()
    {
        return DB::selectOne(self::$table);        
    }

    public static function update()
    {
        return DB::update(self::$table);                
    }

    public static function delete()
    {
        return DB::delete(self::$table);        
    }

    public static function insert()
    {
        return DB::insert(self::$table);     
    }
 
    // metodos personalizados ...
    
}';
return $mold;
}

function mold_cron_job($string)
{
$mold =
'*/1 * * * * cd '.$string.'; php -f Cronjob_Inicializer.php >/dev/null 2>&1 &
';
return $mold;
}

function mold_crontab($string)
{
$mold =
'<?php
require dirname(__DIR__,2).\'/core/Resources/Requires.php\';
$schedule = new Core\Cron; 

// execute classes ou funcoes na hora programada
// CUIDADO: se o escript for muito demorado e recomendado que se crie outro documento cronjob para que seja executado de forma assíncrona
// Voce pode verificar se o comando foi executado em App/Logs/cronjob.log

//--------------------------------------------------------------------------
// Tarefa: '.$string.'
//--------------------------------------------------------------------------

$schedule->everyMinute(1,function(){

})->description(\''.$string.' a cada 1 minuto\');

// $schedule->cron(\'23:45\',27,04,2022,[classExample::class, \'example\'])->description(\'data especifica\');

// $schedule->everyHour(1,[classExample::class, \'example\'])->description(\'a cada 1 hora\');

// $schedule->dailyAt(\'04:30\',[classExample::class, \'example\'])->description(\'na hora 04:30 todos os dias\');

// $schedule->everyMonth(5,\'23:45\',[classExample::class, \'example\'])->description(\'as 23:45 do dia 5 de cada mes\');

// $schedule->yearly([classExample::class, \'example\'])->description(\'no inicio de cada ano 01/01/xxxx na hora 00:00\');

$schedule->execute();

//---------------------------------------------------------------------------';
return $mold;
}