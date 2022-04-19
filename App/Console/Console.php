<?php
namespace App\Console;
use App\Conexao;
use App\Database\Migration;

class Console
{
    private $comand;
    private $render = false;

    public function __construct()
    {
        $string = "";
        global $argv;
        foreach ($argv as $console) {
            $string .= $console . " ";
        }
        $this->comand = trim($string);
    }

    public function reader()
    {
        if ($this->comand == 'mcquery') {
            $this->render = true;
            $this->dashboard();
            die();
        }

        if ($this->comand == 'mcquery env') {
            $this->render = true;

            if(file_exists('.env')){
                echo "\033[1;31msubstituir o .env atual ? (s/n)\033[0m ";
                $console_env = (string)readline('');
                if ($console_env == 's') {
                    $this->newEnv();
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    die();
                }
            }else{
                $this->newEnv();
            }           
        }

        if ($this->comand == 'mcquery cache:env') {
            $this->render = true;
            if (file_exists('App/cache/env.php')) {
                unlink('App/cache/env.php');
                echo "\033[1;31mcache env desativado\033[0m" . PHP_EOL;
            } else {
                $this->env_cache();
            }
        }

        if ($this->comand == 'mcquery conexao') {
            $this->render = true;
            $this->conexao();
        }

        if ($this->comand == 'mcquery install') {
            $this->render = true;
            $this->composerInstall();
        }

        if ($this->comand == 'mcquery autoload') {
            $this->render = true;
            shell_exec('composer dumpautoload');
            echo "\033[0;32mautoload atualizado com sucesso\033[0m" . PHP_EOL;
            die();
        }

        if ($this->comand == 'mcquery migrate') {
            $this->render = true;
            (new Migration)->migrate();
            $this->composerUpdate();
            die();
        }

        if (strpos($this->comand, 'mcquery database:') === 0) {
            $this->render = true;
            $controller_s = str_replace("mcquery database:", "", $this->comand);
            $controller_s = str_replace(" ", "", $controller_s);

            if (!preg_match("/^[a-zA-Z _]*$/", $controller_s)) {
                echo "\033[1;31merro: nome inválido '$controller_s'\033[0m" . PHP_EOL;
                die();
            } else {
                (new Migration)->newDatabase($controller_s);
            }
            die();
        }

        if ($this->comand == 'mcquery list:migrations') {
            $this->render = true;
            (new Migration)->list();
        }

        if (strpos($this->comand, 'mcquery drop:') === 0) {
            $this->render = true;
            $table = str_replace('mcquery drop:', "", $this->comand);
            $table = str_replace(" ", "", $table);
            if (!preg_match("/^[a-zA-Z _]*$/", $table)) {
                echo "\033[1;31mnome da tabela inválido\033[0m" . PHP_EOL;
                die();
            } else {
                echo "\033[1;31mexcluir tabela '$table' ? (s/n)\033[0m ";
                $console = (string)readline('');
                if ($console == 's') {
                    (new Migration)->console_drop($table);
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    die();
                }
            }
        }

        if (strpos($this->comand, 'mcquery controller:') === 0) {
            $this->render = true;
            $controller_s = str_replace("mcquery controller:", "", $this->comand);
            $controller_s = str_replace(" ", "", $controller_s);
            $this->newController($controller_s);
        }

        if (strpos($this->comand, 'mcquery model:') === 0) {
            $this->render = true;
            $controller_m = str_replace("mcquery model:", "", $this->comand);
            $controller_m = str_replace(" ", "", $controller_m);
            (new Migration)->newModel($controller_m);
            $this->composerUpdate();
        }

        // fim do reader
        if ($this->render == false) {
            echo "\033[1;31mcomando inválido\033[0m" . PHP_EOL;
            die();
        }
    }

    private function dashboard()
    {
        if (file_exists('App/cache/env.php')) {
            $cache = "\033[0;32mativo\033[0m" . PHP_EOL;
        } else {
            $cache = "\033[1;31mdesativado\033[0m" . PHP_EOL;;
        }

        echo "\033[1;34m 
 mcquery v1.0.02
 _ __ ___   ___ __ _ _   _  ___ _ __ _   _ 
 | '_ ` _ \ / __/ _` | | | |/ _ \ '__| | | |
 | | | | | | (_| (_| | |_| |  __/ |  | |_| |
 |_| |_| |_|\___\__, |\__,_|\___|_|   \__, |
                   |_|                |___/  
        \033[0m" . PHP_EOL . PHP_EOL;
        echo "\033[1;33m comandos disponiveis:\033[0m" . PHP_EOL;
        echo "\033[0;32m controller:Nome\033[0m cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta" . PHP_EOL;
        echo "\033[0;32m autoload\033[0m atualiza o autoload de classes" . PHP_EOL;
        echo "\033[0;32m conexao\033[0m testa a conexão com o banco de dados" . PHP_EOL;
        echo "\033[0;32m install\033[0m instala as dependências do composer" . PHP_EOL;
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



    private function newController(string $string)
    {
        $local = explode("/", $string);
        $total = count($local);
        $nameclass = $local[$total - 1];
        $folder = "";
        $namespace = "";

        $count = 0;
        foreach ($local as $key) {
            if ($count < $total - 1) {
                $folder .= $key . "/";
                $namespace .= "\\" . $key;

                if (!file_exists("Controllers/$folder")) {
                    mkdir("Controllers/$folder", 0777, true);
                }
            }
            $count++;
        }

        if ($nameclass == "") {
            echo "\033[1;31mnome do controller não informado\033[0m" . PHP_EOL;
            die();
        } else {
            if (!preg_match("/^[a-zA-Z _]*$/", $nameclass)) {
                echo "\033[1;31mnome do controller inválido\033[0m" . PHP_EOL;
                die();
            }
            $file = controller($nameclass, $namespace);

            $confirm = true;
            if (file_exists("Controllers/$folder$nameclass.php")) {
                echo "\033[1;31msubstituir controller '$nameclass' ? (s/n)\033[0m ";
                $console = (string)readline('');
                if ($console == 's') {
                    $confirm == true;
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    $confirm == false;
                    die();
                }
            }

            if ($nameclass == 'Controller' or $nameclass == 'controller') {
                echo "\033[1;31meste nome de controller não pode ser usado\033[0m" . PHP_EOL;
            } else {
                if ($confirm == true) {
                    file_put_contents('Controllers/' . $folder . '' . $nameclass . '.php', $file);
                    $this->composerUpdate();
                    echo "\033[0;32mcontroller ( $nameclass ) criado com sucesso\033[0m" . PHP_EOL;
                    die();
                }
            }
        }
    }

    private function env_cache()
    {
        if (file_exists('App/cache/env.php')) {
            unlink('App/cache/env.php');
        }

        $env = (new Env)->env;
        $file = cacher(array_filter($env));
        file_put_contents('App/cache/env.php', $file);
        echo "\033[0;32mcache env ativado\033[0m" . PHP_EOL;
    }

    private function newEnv()
    {
        $file = new_env();
        file_put_contents('.env', $file);
        if(file_exists('.env')){
            echo "\033[0;32m.env criado com sucesso \033[0m" . PHP_EOL;
            die();
        }else{
            echo "\033[1;31mfalha ao criar .env\033[0m" . PHP_EOL;
        }
        
    }

    private function conexao()
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
        die();
    }

    private function composerInstall()
    {
        shell_exec('composer install');
        echo "\033[0;32mdependências do composer instaladas com sucesso\033[0m" . PHP_EOL;
        die();
    }

    private function composerUpdate()
    {
        shell_exec('composer dumpautoload');
        return;
    }
}