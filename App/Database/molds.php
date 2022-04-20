<?php
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
    $table->date_created(),
    $table->date_edited()

],$table->result());';
return $mold;
}

function model($string)
{
$file =
'<?php
namespace Models;
use App\Database\Model;

class '.$string.'
{ 
    /** 
     * @example $arguments "where" => ["nome" => "mcquery","sobrenome" => "haley"]
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
return $file;
}

function db_cacher($array){
$data =
'<?php
$cache = 
'.var_export($array,true).';';
return $data;
}