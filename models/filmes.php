<?php
namespace Models;
use Core\Model\DB;
use Core\Model\Model;

class filmes implements Model
{ 
    private static string $table = 'filmes';
    
    public const id = 'id';        
    public const titulo = 'titulo';        
    public const descricao = 'descricao';        
    public const elenco = 'elenco';        
    public const img = 'img';        
    public const trailer = 'trailer';        
    public const genero = 'genero';        
    public const lancamento = 'lancamento';        
    public const media_votos = 'media_votos';        
    public const popular = 'popular';        
    public const imdb = 'imdb';        
    public const tmdb = 'tmdb';        
    public const uauflix = 'uauflix';

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