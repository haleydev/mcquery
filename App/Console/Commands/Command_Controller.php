<?php
namespace App\Console\Commands;

class Command_Controller
{   
    public function controller(string $string)
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

                if (!file_exists(MCQUERY."/Controllers/$folder")) {
                    mkdir(MCQUERY."/Controllers/$folder", 0777, true);
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
            $file = mold_controller($nameclass, $namespace);

            $confirm = true;
            if (file_exists(MCQUERY."/Controllers/$folder$nameclass.php")) {
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
                    file_put_contents(MCQUERY.'/Controllers/' . $folder . '' . $nameclass . '.php', $file);
                    shell_exec('composer dumpautoload');
                    echo "\033[0;32mcontroller ( $nameclass ) criado com sucesso\033[0m" . PHP_EOL;
                    die();
                }
            }
        }              
    }
}