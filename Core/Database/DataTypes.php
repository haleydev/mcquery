<?php
namespace Core\Database;

class DataTypes
{
    private $count = 0; 
    private $migration = null;    
    private $default = [];
    private $coluns = [];
    private $alter = [];
    private $drop = [];
    private $error =[];

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
    public function string(string $name, int $size = 255)
    { 
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
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name INT");
        }
        
        return $this;
    }

    /**
     * Coluna tipo bigint.
     * @param string $name     
     */
    public function big_int(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name BIGINT");
        }
        
        return $this;
    }

    /**
     * Coluna tipo float.
     * @param string $name     
     */
    public function float(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name FLOAT");
        }

        return $this;        
    }

    /**
     * Coluna tipo double.
     * @param string $name     
     */
    public function double(string $name)
    {
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name DOUBLE");
        }

        return $this;        
    }

    /**
     * Coluna tipo decimal recomendado para dinheiro.
     * Lembrando que se deve usar '.' ao inserir no banco.
     * @param $size padrão 10,2
     * @param string $name     
     */
    public function decimal(string $name, $size = '10,2')
    {    
        if ($this->filter_name($name, "nome da coluna '$name' inválido!")) {
            $this->add("$name DECIMAL($size)");
        } 

        return $this;        
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
    public function created_dt()
    {
        $this->add("created_dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }

    /**
     * Data de atualizacao.      
     */
    public function edited_dt()
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
    public function alter(string $colun,$update)
    {
        if (isset($this->default[$this->count - 1])) {
            $array =  array($colun, $this->coluns[$this->count - 1] . " " . $this->default[$this->count - 1]);
            array_push($this->alter, $array);
        } else {
            $array =  array($colun, $this->coluns[$this->count - 1]);
            array_push($this->alter, $array);
        }

        unset($this->coluns[$this->count - 1]);       
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
        array_push($this->coluns, $string);
        $this->count++;
    }

    // filters
    private function filter_name(string $name, string $error_msg)
    { 
        if (!preg_match("/^[a-zA-Z _]*$/", $name)) {
            array_push($this->error, $error_msg); 
        } else {
            return true;
        }
    }

    // finalize ------------------------------------------------------------------------------------------
    /**
     * Retorna todas as informações das colunas passadas.
     * @return array      
     */
    public function migrate()
    {
        // name file migration
        $file_migrate = debug_backtrace()[0]['file'];        
        if(strpos($file_migrate,'\\')){
            $bath_array = explode("\\", $file_migrate);
        }else{
            $bath_array = explode("/", $file_migrate);
        }   

        $bath_count = count($bath_array) - 1;
        $migration = str_replace(".php", "", $bath_array[$bath_count]); 
        $this->migration = $migration;
       
        // defalt
        $count = 0;
        foreach ($this->coluns as $value) {                
            if (isset($this->default[$count])) {
                $this->coluns[$count] = $value . " " . $this->default[$count];
            }

            $count++;
        }

        // result
        $array = array(
            "error" => $this->error,
            "migration" => $this->migration,
            "coluns" => $this->coluns,
            "alter" => $this->alter,
            "drop" => $this->drop
        );

        return $array;        
    }
}