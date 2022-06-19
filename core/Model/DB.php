<?php
namespace Core\Model;
use Core\Database\Query;

class DB
{
    /** 
    * @example $arguments "where" => ["nome" => "mcquery","sobrenome" => "haley"] ou count(*) para contar registros
    * @example $arguments "like" => ["nome" => "mc"]
    * @example $arguments "coluns" => "email,nome"
    * @example $arguments "limit" => "10"
    * @example $arguments "order" => id DESC | id ASC | id DESC | RAND() 
    * @example $arguments "join" => "id = filmes.id"
    * @return array|null Támbem retornará null em caso de erro, retorna todos os itens da tabela se se não passar nenhum argumento.
    */
    public static function select(string $table, array $arguments = [])
    {
        return (new Query)->table($table)->select($arguments);        
    }

    /** 
    * @example $arguments "where" => ["nome" => "mcquery","sobrenome" => "haley"] ou count(*) para contar registros
    * @example $arguments "like" => ["nome" => "mc"]
    * @example $arguments "coluns" => "email,nome"
    * @example $arguments "order" => id DESC | id ASC | id DESC | RAND() 
    * @example $arguments "join" => "id = filmes.id"
    * @return array|null Retornará null em caso de erro.
    */
    public static function selectOne(string $table, array $arguments = [])
    {
        return (new Query)->table($table)->selectOne($arguments); 
    }

    /**
    * @example $arguments "update" => ["name" => "mcquery","sobrenome" => "example"]
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */
    public static function update(string $table, array $arguments)
    {
        return (new Query)->table($table)->update($arguments);            
    }

    /** 
    * CUIDADO se não for especificado em where ou limit toda a tabela sera excluida.
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */ 
    public static function delete(string $table, array $arguments = [])
    {
        return (new Query)->table($table)->delete($arguments);
    }

    /**       
    * @example $arguments ["nome" => "mcquery","sobrenome" => "haley"]
    * @return true|false Támbem retornará false em caso de erro. 
    */
    public static function insert(string $table, array $arguments)
    {
        return (new Query)->table($table)->insert($arguments);  
    }

    /** 
    * @example $arguments "where" => ["nome" => "mcquery","sobrenome" => "haley"] ou count(*) para contar registros
    * @example $arguments "like" => ["nome" => "mc"]
    * @example $arguments "coluns" => "email,nome"
    * @example $arguments "limit" => "1"
    * @example $arguments "order" => "DESC" - ASC | DESC | RAND() 
    * @example $arguments "join" => "id = filmes.id"
    * @return int|null Retornará null em caso de erro.
    */
    public static function count(string $table, array $arguments = [])
    {
        return (new Query)->table($table)->count($arguments);              
    }

    /** 
    * @param string $query DELETE FROM user WHERE id = ? and name = ?
    * @param array $bindparams [$id,$name]  
    * @return int|array|false|PDOException
    */
    public static function query(string $query, array $bindparams = [])
    {
        return (new Query)->query($query, $bindparams);              
    }
}