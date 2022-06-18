<?php
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
use Core\Controller;

class '.$string.' extends Controller
{
    public function render()
    {  
        $this->view = "";
        $this->title = "";       

        return template("layouts/main", $this); 
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

function mold_env_cacher($array){
$mold =
'<?php
$cache = 
'.var_export($array,true).';';
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

function mold_model($string,$coluns)
{
$mold =
'<?php
namespace Models;
use Core\Database\Model;

class '.$string.'
{ 
    '.$coluns.'
    /** 
     * @example $arguments "where" => ["nome" => "mcquery","sobrenome" => "haley"] ou count(*) para contar registros
     * @example $arguments "like" => ["nome" => "mc"]
     * @example $arguments "coluns" => "email,nome"
     * @example $arguments "limit" => "1"
     * @example $arguments "order" => "DESC" - ASC | DESC | RAND() 
     * @example $arguments "join" => "id = filmes.id"
     * @return array|null Támbem retornará null em caso de erro, retorna todos os itens da tabela se se não passar nenhum argumento.
     */
    static public function select(array $arguments = [])
    {            
        return (new Model)->table(\''.$string.'\')->select($arguments);        
    }
    
    /**       
     * @example $arguments ["nome" => "mcquery","sobrenome" => "haley"]
     * @return true|false Támbem retornará false em caso de erro. 
     */
    static public function insert(array $arguments)
    {            
        return (new Model)->table(\''.$string.'\')->insert($arguments);        
    }
    
    /**
    * @example $arguments "update" => ["name" => "mcquery","sobrenome" => "example"]
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */
    static public function update(array $arguments)
    {            
        return (new Model)->table(\''.$string.'\')->update($arguments);        
    }

    /** 
    * CUIDADO se não for especificado em where ou limit toda a tabela sera excluida.
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */    
    static public function delete(array $arguments = null)
    {            
        return (new Model)->table(\''.$string.'\')->delete($arguments);        
    }
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