<?php
namespace Models;
use Core\Model\Model;

class teste implements Model
{ 
    private static string $db_table = 'teste';

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
        
    }

    public static function selectOne()
    {
        
    }

    public static function update()
    {
        
    }

    public static function delete()
    {
        
    }

    public static function insert()
    {
        
    }
}