<?php
namespace Core\Model;
use Core\Model\Query;

class DB
{
    /**   
     * Query SELECT 1 resultado
     * @param string $table tabela do banco de dados
     */
    public static function selectOne(string $table)
    {
        $select = new QuerySelectOne($table);      
        return $select;
    }

    /**   
     * Query SELECT
     * @param string $table tabela do banco de dados
     */
    public static function select(string $table)    
    {      
        $select = new QuerySelect($table);      
        return $select;
    }

    /**   
     * Query UPDATE
     * @param string $table tabela do banco de dados
     */
    public static function update(string $table)
    {
        $update = new QueryUpdate($table);      
        return $update; 
    }

    /**   
     * Query DELETE
     * @param string $table tabela do banco de dados
     */
    public static function delete(string $table)
    {
        $delete = new QueryDelete($table);      
        return $delete;
    }

     /**   
     * Query INSERT
     * @param string $table tabela do banco de dados
     */
    public static function insert(string $table)
    {
        $insert = new QueryInsert($table);      
        return $insert;         
    }

    /** 
    * @return array|false|error
    */
    public static function query(string $query, array $bindparams = [])
    {
        return (new Query)->query($query, $bindparams);              
    }
}