<?php
namespace App;
use App\Conexao;

class Controller
{       
    public $data = null;
    public $total = null;

    /**
     * Retorna uma view contida em Templates/views.
     * @return string|require   
     */    
    public function view(string $view = null)
    { 
        if(isset($this->view) and $view == null){
            $view = $this->view;
        }

        $fileview = "Templates/views/$view.php";
        if(file_exists($fileview)){
            require $fileview;
        }else{
            echo "view não encontrada";
        } 
        
        return $this;        
    }
 
    /**
     * Retorna um layout contido em Templates/layouts.  
     * @return string|require         
     */
    public function layout(string $layout = null)
    {  
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

    /**
     * Retorna um include contido em Templates/includes.  
     * @return string|require         
     */   
    public function include(string $include)
    {  
        if(file_exists("Templates/includes/$include.php")){
            require "Templates/includes/$include.php";
        }else{
            echo "include não encontrado";
            return;
        }

        return $this;
    }

    /**
     * Retorna o resultado de uma query.
     * Varias queries podem ser feitas em uma mesma pagina.
     * Consulte a documentação https://github.com/haleydev/mcquery#controllers para saber como fazer isso.      
     */ 

    protected function query( array $querys = null)
    {   
        $conexao = new Conexao;
        $conexao->pdo();
        $count = 0;     

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