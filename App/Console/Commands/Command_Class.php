<?php
namespace App\Console\Commands;

class Command_Class
{   
    public function class(string $string)
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

                if (!file_exists(MCQUERY."/App/Classes/$folder")) {
                    mkdir(MCQUERY."/App/Classes/$folder", 0777, true);
                }
            }
            $count++;
        }

        if ($nameclass == "") {
            echo "\033[1;31mnome da classe não informado\033[0m" . PHP_EOL;
            die();
        } else {
            if (!preg_match("/^[a-zA-Z _]*$/", $nameclass)) {
                echo "\033[1;31mnome da classe inválido\033[0m" . PHP_EOL;
                die();
            }
            $file = mold_class($nameclass, $namespace);

            $confirm = true;
            if (file_exists(MCQUERY."/App/Classes/$folder$nameclass.php")) {
                echo "\033[1;31msubstituir classe '$nameclass' ? (s/n)\033[0m ";
                $console = (string)readline('');
                if ($console == 's') {
                    $confirm == true;
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    $confirm == false;
                    die();
                }
            }
         
            if ($confirm == true) {
                file_put_contents(MCQUERY.'/App/Classes/' . $folder . '' . $nameclass . '.php', $file);
                shell_exec('composer dumpautoload');
                echo "\033[0;32mclasse ( $nameclass ) criada com sucesso\033[0m" . PHP_EOL;
                die();
            }
            
        }              
    }
}