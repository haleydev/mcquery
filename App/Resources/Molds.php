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

function mold_controller($string,$namespace = null)
{
$mold =
'<?php
namespace Controllers;
use App\Controller;

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
use App\Database\Migration;
require "./App/Database/require.php";
    
(new Migration)->table([$table->name("'.$name.'"),

    $table->id(),
    $table->string(\'nome\',100),  
    $table->string(\'sobrenome\', 100),
    $table->string(\'password\',100),
    $table->int(\'idade\'),    
    $table->edited_dt(),
    $table->created_dt()

],$table->result());';
return $mold;
}

function mold_model($string)
{
$mold =
'<?php
namespace Models;
use App\Database\Model;

class '.$string.'
{ 
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
'*/1 * * * * cd '.$string.'; php -f Cron_Inicializer.php >> '.$string.'../Logs/cronjob.txt NEWLINE
';
return $mold;
}