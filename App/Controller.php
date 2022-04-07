<?php
namespace App;
use App\Conexao;

class Controller
{       
    public $data = null;
    public $total = null;

    // retorna um view contida em Templates/views
    public function view($view = null){ 
        if(isset($this->view) and $view == null){
            $view = $this->view;
        }

        $fileview = "Templates/views/$view.php";
        if(file_exists($fileview)){
            require $fileview;
        }else{
            echo "view não encontrada";
        } return $this;        
    }

    // retorna layout contida em Templates/layouts
    // dentro do layout deve ser incluido o view ($this->view($view))
    public function layout($layout = null){  
        if(isset($this->layout) and $layout == null){
            $layout = $this->layout;
        }
        if(file_exists("Templates/layouts/$layout.php")){
            require "Templates/layouts/$layout.php";
            return $this;
        }else{
            echo "layout não encontrado";
            return;
        }
        return $this;
    }

    // retorna layout contida em Templates/includes
    public function include($include){  
        if(file_exists("Templates/includes/$include.php")){
            require "Templates/includes/$include.php";
        }else{
            echo "include não encontrado";
            return;
        }
        return $this;
    }

    // retorna o resultado de uma query
    // varias queries podem ser feitas em uma mesma pagina
    // pode ser acessado na view com $this->data[1]
    public function query( array $querys = null){   
        $conexao = new Conexao;
        $conexao->pdo();
        $count = 1;     

        foreach($querys as $query){ 
            $sql = $conexao->conect->prepare($query);
            $sql->execute();
            $this->data[$count] = $sql->fetchAll();
            $this->total[$count] = $sql->rowCount();
            $count++;
        }
        $conexao->close();
        return $this;
    } 
}