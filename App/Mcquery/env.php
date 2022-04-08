<?php
$array = array_filter(file('.env'));
$array_env = [];

foreach($array as $value){
    if($value[0] != "#"){
        $item = explode( "=", $value);        
        if(isset($item[1])){
            $value_e = trim($item[1]);
        }else{
            $value_e = null;
        }        
        $array_env[trim($item[0])] = $value_e;                      
    }   
}

// retorna o valor declarado em .env
function env(string $value){
    global $array_env;
    if(array_key_exists($value,$array_env)){
        return $array_env[$value];
    }else{
        return null;
    }
}

// verifica se os valores estao declarados ou vazios em .env retornando true ou false
function env_required(string $values){
    global $array_env;
    $result = true;
    $array = explode(',',$values);
    foreach($array as $key){
        if(!array_key_exists($key,$array_env)){
            $result = false;
        }else{
            if($array_env[$key] == null){
                $result = false;
            }
        }   
    }
    return $result;
}