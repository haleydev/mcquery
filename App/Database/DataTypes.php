<?php
namespace App\Database;

class DataTypes
{
    /**
     * Retorna nome da tabela a ser criada.
     * @return string $name      
     */

    private $count = 0;
    private $count_alter = 1;

    private $name = "???";
    private $default = [];
    private $array = [];
    private $alter = [];
    private $drop = [];

    /**
     * Nome da tabela a ser criada.
     * @param string $name      
     */
    public function name(string $colun)
    {
        if ($this->filter_name($colun, "nome da tabela '$colun' inválido!")) {
            $this->name = $colun;
            return;
        }
    }

    /**
     * Cria a tabela com chave primária id.
     */
    public function id()
    {
        $this->add("id INT AUTO_INCREMENT PRIMARY KEY");
    }

    /**
     * Coluna tipo varchar.
     * @param string $nome
     * @param int $size tamanho máximo , paradrão 255          
     */
    public function string(string $name, int $size = null)
    {
        if ($size == null) {
            $size = 255;
        }

        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name VARCHAR($size)");
        }
        return $this;
    }

    /**
     * Coluna tipo text 65,535.
     * @param string $name
     */
    public function text(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name TEXT");
        }

        return $this;
    }

    /**
     * Coluna tipo text medium 16,777,215.
     * @param string $name
     */
    public function text_medium(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name MEDIUMTEXT");
        }

        return $this;
    }

    /**
     * Coluna tipo text medium 4,294,967,295.
     * @param string $name
     */
    public function text_long(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name LONGTEXT");
        }

        return $this;
    }

    /**
     * Coluna tipo json.
     * @param string $name
     */
    public function json(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name JSON");
        }

        return $this;
    }

    /**
     * Coluna tipo inteiro.
     * @param string $name
     */
    public function int(string $name)
    {
        $this->add("$name INT");
    }

    /**
     * Coluna tipo bigint.
     * @param string $name     
     */
    public function big_int(string $name)
    {
        $this->add("$name BIGINT");
    }

    /**
     * Coluna tipo float.
     * @param string $name     
     */
    public function float(string $name)
    {
        $this->add("$name FLOAT");
    }

    /**
     * Coluna tipo double.
     * @param string $name     
     */
    public function double(string $name)
    {
        $this->add("$name DOUBLE");
    }

    /**
     * Coluna tipo decimal recomendado para dinheiro.
     * Lembrando que se deve usar '.' ao inserir no banco.
     * @param $size padrão 10,2
     * @param string $name     
     */
    public function decimal(string $name, $size = null)
    {
        if($size == null){
            $size = '10,2';
        }
        $this->add("$name DECIMAL($size)");
    }

    /**
     * Coluna tipo date.
     * @param string $colun         
     */
    public function date(string $name_date)
    {
        if ($this->filter_name($name_date, "nome da coluna '$name_date' inválido!")) {
            $this->add("$name_date DATE");
        }
    }

    /**
     * Data de criacao.    
     */
    public function date_created()
    {
        $this->add("created_dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }

    /**
     * Data de atualizacao.      
     */
    public function date_edited()
    {
        $this->add("edited_dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }

    /**
     * Valor predefinido da coluna
     * @param string $def
     */
    public function default(string $def)
    {
        $this->default[$this->count - 1] = "DEFAULT '$def'";
    }

    /**
     * Altera a estrutura de uma coluna.
     * @param string $colun              
     */
    public function alter(string $colun)
    {
        if (isset($this->default[$this->count - 1])) {
            $array =  array($colun, $this->array[$this->count - 1] . " " . $this->default[$this->count - 1]);
            array_push($this->alter, $array);
        } else {
            $array =  array($colun, $this->array[$this->count - 1]);
            array_push($this->alter, $array);
        }

        unset($this->array[$this->count - 1]);
        $this->count_alter++;
    }

    /**
     * Remove uma coluna.
     * @param string $colun       
     */
    public function drop(string $colun)
    {
        $string = $colun;
        array_push($this->drop, $string);
    }

    private function add(string $string)
    {
        array_push($this->array, $string);
        $this->count++;
    }

    // filters
    private function filter_name(string $name, string $error_msg)
    {
        if (!preg_match("/^[a-zA-Z _]*$/", $name)) {
            echo "\033[1;31merro (tabela " . $this->name . "): $error_msg\033[0m" . PHP_EOL;
            die();
        } else {
            return true;
        }
    }

    // finalize ------------------------------------------------------------------------------------------
    public function result()
    {
        // atributes  
        if (count($this->array) > 0) {
            $count = 0;

            // defalt
            foreach ($this->array as $value) {                
                if (isset($this->default[$count])) {
                    $this->array[$count] = $value . " " . $this->default[$count];
                }

                $count++;
            }

            // result
            $array = array(
                "table" => $this->name,
                "values" => $this->array,
                "alter" => $this->alter,
                "drop" => $this->drop
            );

            return $array;
        } else {
            $bath_array = explode("\\", debug_backtrace()[0]['file']);
            $bath_count = count($bath_array) - 1;
            $migration = str_replace(".php", "", $bath_array[$bath_count]);
            echo "\033[1;31merro: $migration não possui nenhuma coluna\033[0m" . PHP_EOL;
            die();
        }
    }
}