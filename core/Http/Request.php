<?php
namespace Core\Http;

class Request 
{
    /**
     * Retorna o valor do parâmetro passado em router.
     * @return string|false
     */
    public static function input($param)
    {
        if (defined('routerget')) {
            if (array_key_exists($param, routerget)) {
                return routerget[$param];
            } else {
                return false;
            }
        } 

        return false;
    }

    public static function get(string|array|null $get = null)
    {    
        if($get === null){
            if($_GET == null){
                return false;
            }
            
            return filter_input_array(INPUT_GET,$_GET);
        }
        
        if(is_array($get)){
            $return = array();        
            foreach ($get as $valid) {
                if (isset($_GET[$valid])) {
                    if ($_GET[$valid] == null or $_GET[$valid] == "") {
                        return false;
                    }else{
                        $return[$valid] = filter_input(INPUT_GET, $valid);                    
                    }
                } else {
                    return false;
                }
            }
            
            return $return;
        }
        
        if(is_string($get)){
            if (isset($_GET[$get])) {
                if ($_GET[$get] == null or $_GET[$get] == "") {
                    return false;
                }else{
                    return filter_input(INPUT_GET, $get);                    
                }
            }
        }      

        return false;
    }

    public static function post(string|array|null $post = null)
    { 
        if($post === null){
            if($_POST == null){
                return false;
            }

            return filter_input_array(INPUT_POST,$_POST);
        }
        
        if(is_array($post)){
            $return = array();        
            foreach ($post as $valid) {
                if (isset($_POST[$valid])) {
                    if ($_POST[$valid] == null or $_POST[$valid] == "") {
                        return false;
                    }else{
                        $return[$valid] = filter_input(INPUT_POST, $valid);                    
                    }
                } else {
                    return false;
                }
            }
            
            return $return;
        }
        
        if(is_string($post)){
            if (isset($_POST[$post])) {
                if ($_POST[$post] == null or $_POST[$post] == "") {
                    return false;
                }else{
                    return filter_input(INPUT_POST, $post);                    
                }
            }          
        }      

        return false;
    }
}