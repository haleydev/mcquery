<?php
namespace Models;
use Core\Database\Model;

class countries
{ 
    public const id = 'id';        
    public const code = 'code';        
    public const countrie = 'countrie';        
    public const img = 'img';

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
        return (new Model)->table('countries')->select($arguments);        
    }
    
    /**       
     * @example $arguments ["nome" => "mcquery","sobrenome" => "haley"]
     * @return true|false Támbem retornará false em caso de erro. 
     */
    static public function insert(array $arguments)
    {            
        return (new Model)->table('countries')->insert($arguments);        
    }
    
    /**
    * @example $arguments "update" => ["name" => "mcquery","sobrenome" => "example"]
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */
    static public function update(array $arguments)
    {            
        return (new Model)->table('countries')->update($arguments);        
    }

    /** 
    * CUIDADO se não for especificado em where ou limit toda a tabela sera excluida.
    * @example $arguments "where" => ["name" => "haley","sobrenome" => "example"]
    * @example $arguments "limit" => "1"
    * @return true|false Támbem retornará false em caso de erro. 
    */    
    static public function delete(array $arguments = null)
    {            
        return (new Model)->table('countries')->delete($arguments);        
    }
}