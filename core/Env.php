<?php
namespace Core;

class Env
{
    /**
     * Array com as informações env.
     */
    public $env = [];
   
    public function __construct()
    {
        if (file_exists(ROOT . '/app/Cache/env.json')) {
            $this->cache();
        } elseif (file_exists(ROOT . '/.env')) {
            $this->env();
        } else {
            die("Aplicação não iniciada, use o comando 'php mcquery' para criar o arquivo de configuração e instalar dependências.");
        }
    }

    private function env()
    {
        $array = array_filter(file(ROOT . '/.env'));
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

        $this->return($array_env);
    }

    private function cache()
    {
        return $this->return(json_decode(file_get_contents(ROOT . '/app/Cache/env.json'),true));
    }

    private function return(array $env)
    {
        if (isset($_SERVER['HTTP_HOST']) and $env['APP_URL'] == 'automatic') {
            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
                $env["APP_URL"] = 'https://' . $_SERVER['HTTP_HOST'];
            } else {
                $env["APP_URL"] = 'http://' . $_SERVER['HTTP_HOST'];
            }
        }

        return $this->env = $env;
    }
}
