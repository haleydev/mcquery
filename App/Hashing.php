<?php
namespace App;

class Hashing
{
    private $pepper = 'd$MC%9d$@que4ry#$8';

    /**
     * Retorna um hash de uma string.
     * @param string $value
     * @return string|false 
     */
    public function hash(string $value){
        $rash =  password_hash($this->pepper.$value, PASSWORD_DEFAULT);
        return $rash;
    }

    /**
     * Verifica se o hash bate com a string, retorna true ou false.
     * @param string $value
     * @param string $hash
     * @return true|false 
     */
    public function check(string $value, string $hash){
        if (password_verify($this->pepper.$value, $hash)) {       
            return true;
        }else{
            return false;
        }
    }
}