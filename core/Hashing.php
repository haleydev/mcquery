<?php
namespace Core;

class Hashing
{
    private $salt = '';

    /**
     * Retorna um hash de uma string.
     * @param string $value
     * @return string|false 
     */
    public function hash_create(string $value){
        $rash = password_hash($this->salt.$value, PASSWORD_DEFAULT);
        return $rash;
    }

    /**
     * Verifica se o hash bate com a string, retorna true ou false.
     * @param string $value
     * @param string $hash
     * @return true|false 
     */
    public function hash_check(string $value, string $hash){
        return password_verify($this->salt.$value, $hash);
    }
}