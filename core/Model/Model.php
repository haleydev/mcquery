<?php
namespace Core\Model;

interface Model
{
    public static function select();  
    public static function selectOne(); 
    public static function update();   
    public static function delete();
    public static function insert();
}