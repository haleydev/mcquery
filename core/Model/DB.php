<?php
namespace Core\Model;
use Core\Model\Query;

class DB
{
    /**   
     * Select banco de dados
     * @param string $table
     */
    public static function selectOne(string $table)
    {
        $select = new QuerySelectOne($table);      
        return $select;
    }

    /**   
     * Select banco de dados '1 resultado'
     * @param string $table
     */
    public static function select(string $table)    
    {      
        $select = new QuerySelect($table);      
        return $select;
    }

    public static function update(string $table, array $arguments)
    {
        return (new Query)->table($table)->update($arguments);            
    }

    public static function delete(string $table, array $arguments = [])
    {
        return (new Query)->table($table)->delete($arguments);
    }

    public static function insert(string $table, array $arguments)
    {
        return (new Query)->table($table)->insert($arguments);  
    }

    /** 
    * @return array|false|PDOException
    */
    public static function query(string $query, array $bindparams = [])
    {
        return (new Query)->query($query, $bindparams);              
    }
}