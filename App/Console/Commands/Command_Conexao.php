<?php
namespace App\Console\Commands;
use App\Conexao;

class Command_Conexao
{   
    public function conexao()
    {
        $conexao = new Conexao;
        $conexao->pdo();
        $conexao->instance;

        if ($conexao->error == true) {
            echo "\033[1;31mfalha na conexão\033[0m" . PHP_EOL;
        } else {
            echo "\033[0;32mconexão realizada com sucesso\033[0m" . PHP_EOL;
        }
        $conexao->close();                 
    }
}