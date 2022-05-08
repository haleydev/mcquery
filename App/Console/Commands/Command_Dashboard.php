<?php
namespace App\Console\Commands;

class Command_Dashboard
{   
    public function dashboard()
    { 
echo PHP_EOL .'Developed by: Warley Rodrigues de Moura';
echo "\033[1;34m 
mcquery v2.4.00 beta
_ __ ___   ___ __ _ _   _  ___ _ __ _   _ 
| '_ ` _ \ / __/ _` | | | |/ _ \ '__| | | |
| | | | | | (_| (_| | |_| |  __/ |  | |_| |
|_| |_| |_|\___\__, |\__,_|\___|_|   \__, |
                  |_|                |___/  
        \033[0m" . PHP_EOL . PHP_EOL;
        echo "\033[1;33m comandos disponiveis\033[0m" . PHP_EOL;
        echo "\033[0;32m server\033[0m ativa servidor de desenvolvimento mcquery" . PHP_EOL;
        echo "\033[0;32m controller:nome\033[0m cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta" . PHP_EOL;      
        echo "\033[0;32m class:nome\033[0m cria uma nova classe, adicione 'pasta/NomeClasse' caso queira adicionar uma subpasta" . PHP_EOL;    
        echo "\033[0;32m conexao\033[0m testa a conexão com o banco de dados" . PHP_EOL;       
        echo "\033[0;32m install\033[0m instala as dependências do composer" . PHP_EOL;
        echo "\033[0;32m autoload\033[0m atualiza o autoload de classes" . PHP_EOL;
        echo "\033[0;32m env\033[0m cria um novo arquivo de configurações" . PHP_EOL;
        echo "\033[0;32m cache:env\033[0m armazena e usa as informações do .env em cache - " . $this->env_check() . PHP_EOL;       

        echo "\033[1;33m base de dados\033[0m" . PHP_EOL;
        echo "\033[0;32m model:nome\033[0m cria um novo model" . PHP_EOL;
        echo "\033[0;32m database:nome\033[0m cria uma nova base de dados" . PHP_EOL;
        echo "\033[0;32m migrate\033[0m executa as bases de dados pendentes e adiciona models" . PHP_EOL;
        echo "\033[0;32m drop:nome\033[0m exclui uma tabela do banco de dados" . PHP_EOL;
        echo "\033[0;32m list:migrations\033[0m lista todas as migrações já executadas" . PHP_EOL . PHP_EOL;

        echo "\033[1;33m cron job\033[0m" . PHP_EOL;
        echo "\033[0;32m cronjob\033[0m ativa/desativa o cron job 'linux debian' - " . $this->cron_check();
        echo "\033[0;32m cronjob:nome\033[0m cria um novo arquivo de tarefas cron job" . PHP_EOL . PHP_EOL;
    }

    private function env_check()
    {
        if (file_exists(MCQUERY.'/App/Cache/env.php')) {
            return "\033[0;32mativo\033[0m" . PHP_EOL;
        } else {
            return "\033[1;31mdesativado\033[0m" . PHP_EOL;;
        }
    }

    private function cron_check()
    {
        if(strtolower(PHP_OS) == 'linux'){   
            $service = shell_exec('service cron status 2>&1');

            if(str_contains($service,'cron is running')){              
                $cron = mold_cron_job(MCQUERY."/Core/Resources/");
                $check = shell_exec('crontab -l 2>&1');

                if(str_contains($check,$cron)){
                    return "\033[0;32mativo\033[0m" . PHP_EOL; 
                }else{
                    return "\033[1;31mdesativado\033[0m" . PHP_EOL;
                }
            }else{
                return "\033[1;31mdesativado\033[0m" . PHP_EOL;
            }           
        }else{
            return "\033[1;31mdesativado\033[0m" . PHP_EOL;
        }   
    }
}