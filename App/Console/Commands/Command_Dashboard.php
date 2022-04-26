<?php
namespace App\Console\Commands;

class Command_Dashboard
{   
    public function dashboard()
    {
        if (file_exists('App/cache/env.php')) {
            $cache = "\033[0;32mativo\033[0m" . PHP_EOL;
        } else {
            $cache = "\033[1;31mdesativado\033[0m" . PHP_EOL;;
        }
echo "\033[1;34m 
mcquery v1.6.00
_ __ ___   ___ __ _ _   _  ___ _ __ _   _ 
| '_ ` _ \ / __/ _` | | | |/ _ \ '__| | | |
| | | | | | (_| (_| | |_| |  __/ |  | |_| |
|_| |_| |_|\___\__, |\__,_|\___|_|   \__, |
                  |_|                |___/  
        \033[0m" . PHP_EOL . PHP_EOL;
        echo "\033[1;33m comandos disponiveis:\033[0m" . PHP_EOL;
        echo "\033[0;32m server\033[0m ativa servidor de desenvolvimento mcquery" . PHP_EOL;
        echo "\033[0;32m controller:Nome\033[0m cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta" . PHP_EOL;        
        echo "\033[0;32m conexao\033[0m testa a conexão com o banco de dados" . PHP_EOL;
        echo "\033[0;32m install\033[0m instala as dependências do composer" . PHP_EOL;
        echo "\033[0;32m autoload\033[0m atualiza o autoload de classes" . PHP_EOL;
        echo "\033[0;32m env\033[0m cria um novo arquivo de configurações (.env)" . PHP_EOL;
        echo "\033[0;32m cache:env\033[0m armazena e usa as informações do .env em cache - $cache" . PHP_EOL . PHP_EOL;

        echo "\033[1;33m base de dados:\033[0m" . PHP_EOL;
        echo "\033[0;32m model:nome\033[0m cria um novo model" . PHP_EOL;
        echo "\033[0;32m database:Nome\033[0m cria uma nova base de dados" . PHP_EOL;
        echo "\033[0;32m migrate\033[0m executa as bases de dados pendentes e adiciona models" . PHP_EOL;
        echo "\033[0;32m drop:tabela\033[0m exclui uma tabela do banco de dados" . PHP_EOL;
        echo "\033[0;32m list:migrations\033[0m lista todas as migrações já executadas" . PHP_EOL;
        echo PHP_EOL;
    }
}