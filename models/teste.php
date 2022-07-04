<?php
namespace Models;
use Core\Model\DB;
use Core\Model\Model;

class teste implements Model
{ 
    private static string $table = 'teste';
    
    public const id = 'id';        
    public const nome = 'nome';        
    public const sobrenome = 'sobrenome';        
    public const email = 'email';        
    public const password = 'password';        
    public const idade = 'idade';        
    public const edited_dt = 'edited_dt';        
    public const created_dt = 'created_dt';

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
    
}