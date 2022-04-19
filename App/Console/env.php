<?php
namespace App\Console;

class Env
{
    public $env = [];

    public function __construct()
    {
        if (file_exists('App/cache/env.php')) {
            $this->cache();
        } elseif (file_exists('.env')) {            
            $this->env();
        } else {
            die("Aplicação não iniciada! arquivo de configuração não encontrado");
        }
    }

    private function env()
    {
        $array = array_filter(file('.env'));
        $array_env = [];
        foreach ($array as $value) {
            if ($value[0] != "#") {
                $item = explode("=", $value, 2);
                if (isset($item[1])) {
                    $value_e = trim($item[1]);
                } else {
                    $value_e = null;
                }
                $array_env[trim($item[0])] = $value_e;
            }
        }
        return $this->env = $array_env;
    }

    private function cache()
    {
        require 'App/cache/env.php';
        $this->env = $cache;
        return;
    }
}