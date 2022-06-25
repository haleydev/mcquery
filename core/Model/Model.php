<?php
namespace Core\Model;

interface Model
{
    /**   
     * Model SELECT 
     */
    public static function select();  

    /**   
     * Model SELECT 1
     */
    public static function selectOne(); 

    /**   
     * Model UPDATE 
     */
    public static function update(); 
    
    /**   
     * Model DELETE 
     */
    public static function delete();

    /**   
     * Model INSERT 
     */
    public static function insert();
}