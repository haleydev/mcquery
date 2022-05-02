<?php
namespace Core\Database;
use Core\Conexao;

require_once 'Core/Resources/Molds.php';

class Migration
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conexao->pdo();
        if ($this->conexao->error) {
            echo "\033[1;31mfalha na conexão com o banco de dados\033[0m" . PHP_EOL;
            die();
        };
    }

    public function new_database($name)
    {
        $name = strtolower($name);
        $m_name = $name . "_" . date("Ymd") . "_" . date("Gis");
        $file = mold_migrate($name);
        file_put_contents('Database/' . $m_name . '.php', $file);
        if (file_exists('Database/' . $m_name . '.php')) {
            echo "\033[0;32mbase de dados $name criada com sucesso\033[0m" . PHP_EOL;
        } else {
            echo "\033[1;31merro ao criar base de dados $name\033[0m" . PHP_EOL;
        }
    }

    public function migrate()
    {
        // cria a tabela migrations se ela nao existir
        $this->table_migrations();

        if ($this->databases() != false) {
            foreach ($this->databases() as $data) {
                echo shell_exec('php Database/' . $data);
            }
            echo "\033[1;33mmigração concluida\033[0m" . PHP_EOL;
        } else {
            echo "\033[1;33m nenhuma migração a fazer\033[0m" . PHP_EOL;
        }
    }

    public function list()
    {
        // cria a table migrations se ela nao existir
        $this->table_migrations();
        $query = "SELECT * FROM migrations";

        $sql = $this->conexao->instance->prepare($query);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $result) {
                echo "\033[0;32m " . $result['migration'] . " \033[0m table:" . $result['table_name'] . " " . $result['execution_dt'] . PHP_EOL;
            }
        } else {
            echo "\033[0;32m Nenhuma migração feita \033[0m" . PHP_EOL;
        }
    }

    public function table($null, array $array)
    {
        $name = strtolower($array['table']);
        $values = $array['values'];
        $alter = $array['alter'];
        $drop = $array['drop'];

        $name_file = debug_backtrace()[0]['file'];
        if(strpos($name_file,'\\')){
            $bath_array = explode("\\", $name_file);
        }else{
            $bath_array = explode("/", $name_file);
        }
      
        $bath_count = count($bath_array) - 1;
        $migration = str_replace(".php", "", $bath_array[$bath_count]);

        if ($this->valid_table($name)) {
            $this->creat_table($name, $values, $migration);
            if(!file_exists('Models/'. $name . '.php')){
                $this->new_model($name);
            }
            echo "\033[0;32mtabela $name adicionada ao banco de dados\033[0m" . PHP_EOL;
        } else {
            if(!file_exists('Models/'. $name . '.php')){
                $this->new_model($name);
            }
            $this->alter_table($name, $values, $alter, $migration, $drop);
        }

        $this->conexao->close();
        return $this;
    }

    private function creat_table($name, $array, $migration)
    {
        $total = count($array);
        $count = 1;
        $colun = "";

        foreach ($array as $item) {
            if ($count == $total) {
                $v = "";
            } else {
                $v = ",";
            }
            $colun .= $item . $v;
            $count++;
        };

        $query =
            "CREATE TABLE `$name`(
        $colun 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $sql = $this->conexao->instance->prepare($query);
        $sql->execute();

        $migri = "INSERT INTO migrations (migration, table_name) VALUES ('$migration', '$name')";
        $sql_migri = $this->conexao->instance->prepare($migri);
        $sql_migri->execute();
        return;
    }

    private function alter_table($table, $array, $alter_colun, $migration, $drop)
    {
        $query_a = "show columns from $table";
        $sql_a = $this->conexao->instance->prepare($query_a);
        $sql_a->execute();
        $count = $sql_a->rowCount();
        $coluns_sql = $sql_a->fetchAll();     

        $coluns = [];
        foreach ($coluns_sql as $c) {
            $coluns[$c['Field']] = $c['Field'];           
        }

        if (count($drop) > 0) {
            foreach ($drop as $colun) {
                // altera coluna
                if(array_key_exists($colun,$coluns)){
                    $query = "ALTER TABLE $table DROP $colun";
                    $sql = $this->conexao->instance->prepare($query);
                    $sql->execute();
                    echo "\033[1;31mcoluna $colun da tabela $table removida ( $migration ) \033[0m" . PHP_EOL;
                }       
            }
        }    

        foreach ($array as $alter) {
            $array_add = explode(" ", $alter);
            // adiociona coluna se nao existir
            if (!array_key_exists($array_add[0], $coluns)) {  
                $query = "ALTER TABLE $table ADD COLUMN $alter";
                $sql = $this->conexao->instance->prepare($query);
                $sql->execute();
                echo "\033[1;31mcoluna $array_add[0] adicionada a tabela $table ( $migration ) \033[0m" . PHP_EOL;
            }
        }

        $alteration = false;
        if (count($alter_colun) > 0) {
            foreach ($alter_colun as $c) {
                $alt_colun = $c[0];
                $alt_value = $c[1];

                 // altera coluna se existir
                if (array_key_exists($alt_colun, $coluns)) {                   
                    $array_alter = explode(" ", $alt_value);
                    $query_up = "ALTER TABLE $table CHANGE COLUMN `$alt_colun` $alt_value";
                    $sql_up = $this->conexao->instance->prepare($query_up);
                    $sql_up->execute();
                    $alteration = true;

                    if ($alt_colun != $array_alter[0]) {
                        echo "\033[1;31mcoluna $alt_colun da tabela $table alterada para $array_alter[0] ( $migration ) \033[0m" . PHP_EOL;
                    } else {
                        echo "\033[1;31mcoluna $alt_colun da tabela $table modificada ( $migration ) \033[0m" . PHP_EOL;
                    }
                }
            }
        }

        $query_b = "show columns from $table";
        $sql_b = $this->conexao->instance->prepare($query_b);
        $sql_b->execute();
        $count_b = $sql_b->rowCount();

        if ($count != $count_b or $alteration == true) {
            $migri = "INSERT INTO migrations (migration, table_name) VALUES ('$migration', '$table')";
            $sql_migri = $this->conexao->instance->prepare($migri);
            $sql_migri->execute();
            echo "\033[1;31mtabela $table atualizada ( $migration ) \033[0m" . PHP_EOL;
        }
    }

    public function new_model(string $string)
    {
        if ($string == "") {
            echo "\033[1;31mnome do model não informado\033[0m" . PHP_EOL;
            return;
        } else {
            if (!preg_match("/^[a-zA-Z _]*$/", $string)) {
                echo "\033[1;31mnome do model inválido\033[0m" . PHP_EOL;
                return;
            }

            $confirm = true;
            if (file_exists("Models/$string.php")) {
                echo "\033[1;31msubstituir model '$string' ? (s/n)\033[0m ";
                $console = (string)readline('');
                if ($console == 's') {
                    $confirm == true;
                } else {
                    echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
                    $confirm == false;
                    return;
                }
            }

            if ($confirm == true) {
                $file = mold_model($string);
                file_put_contents('Models/' . strtolower($string) . '.php', $file);               
                echo "\033[0;32mmodel $string criado com sucesso \033[0m" . PHP_EOL;
                return;
            }
        }
    }

    private function table_migrations()
    {
        if ($this->valid_table('migrations')) {
            $query =
                "CREATE TABLE `migrations`(
                ID BIGINT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(250),
                table_name VARCHAR(250),                
                execution_dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

            $sql = $this->conexao->instance->prepare($query);
            $sql->execute();
        }
    }

    private function databases()
    {
        if (!(count(glob("Database/*")) === 0)) {
            $array[] = "";
            $count = 0;

            foreach (scandir('Database') as $data) {
                if (strrpos($data, '.php')) {
                    $array[$count] = $data;
                    $count++;
                };
            }

            return $array;
        } else {
            return false;
        }
    }

    /**
     * Retorna true se nao existir false se axistir
     * @return true|false
     */
    protected function valid_table($name)
    {
        $query = "SHOW TABLES LIKE '$name'";
        $sql = $this->conexao->instance->prepare($query);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    protected function value_exist($table, $where, $value)
    {
        $query = "SELECT * FROM $table WHERE $where = '$value' LIMIT 1";
        $sql = $this->conexao->instance->prepare($query);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function drop_table($table)
    {
        if (!$this->valid_table($table)) {
            $query = "DROP TABLE $table";
            $sql_drop = $this->conexao->instance->prepare($query);
            $sql_drop->execute();
            return true;
        } else {
            return false;
        }
    }

    public function console_drop($table)
    {
        $this->table_migrations();

        if ($table == 'migrations') {
            echo "\033[1;31ma tabela $table não pode ser excluida\033[0m" . PHP_EOL;
        } else {
            if ($this->drop_table($table) === true) {
                $query = "SELECT migration,table_name FROM migrations where table_name = '$table'";
                $sql = $this->conexao->instance->prepare($query);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $this->result = $sql->fetchAll();
                    foreach ($this->result as $date) {
                        $file = strtolower($date['table_name']) . ".php";
                        if (file_exists("Models/" . $file)) {
                            unlink("Models/" . $file);
                            echo "\033[0;32mmodel $table excluida\033[0m" . PHP_EOL;
                        }
                    }
                }      

                echo "\033[0;32mtabela $table excluida do banco de dados\033[0m" . PHP_EOL;
                $this->conexao->close();                
            } else {
                echo "\033[1;31ma tabela $table não existe\033[0m" . PHP_EOL;
            }
        }
    }
}