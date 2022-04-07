<?php
namespace App\Mcquery;
use App\Conexao;

class ControllerConsole
{
    protected $string;

    public function dashboard()
    {
        echo PHP_EOL;
        echo "\033[1;34mBem vindo ao mcquery\033[0m".PHP_EOL.PHP_EOL;    
        echo "\033[1;32mComandos".PHP_EOL;   
        echo "\033[1;93mconfig\033[0m cria o arquivo de configurações (config.ini) e instala dependências".PHP_EOL;   
        echo "\033[1;93mcontroller:Nome\033[0m cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta".PHP_EOL;  
        echo "\033[1;93mmodel:Nome\033[0m cria um novo model".PHP_EOL;     
        echo "\033[1;93mconexao\033[0m testa a conexão com o banco de dados".PHP_EOL; 
        echo "\033[1;93mautoload\033[0m atualiza o autoload de classes".PHP_EOL;         
        echo PHP_EOL;        
        return $this;
    }

    public function newController(string $string)
    {        
        $this->string = str_replace("mcquery controller:", "", $string);
        $this->string = str_replace(" ", "", $this->string);
        $local = explode("/", $this->string);
        $total = count($local);
        $nameclass = $local[$total - 1];   
        $folder = "";
        $namespace = "";

        $count = 0;
        foreach($local as $key){
            if($count < $total - 1){
                $folder.= $key."/";
                $namespace.= "\\".$key;

                if(!file_exists("Controllers/$folder")){
                    mkdir("Controllers/$folder", 0777, true); 
                }  
            } $count++;
        }

        if($nameclass == ""){
            echo PHP_EOL."\033[1;31mNome do controller não informado!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }else{
            $file = controller($nameclass,$namespace);
            file_put_contents('Controllers/'.$folder.''.$nameclass.'.php', $file);
            $this->composerUpdate();
            echo PHP_EOL."\033[0;32mController ( $nameclass ) criado com sucesso \033[0m".PHP_EOL.PHP_EOL;
            die();
        }
    }

    public function conexao(){
        $conexao = new Conexao;
        $conexao->pdo();
        $conexao->conect;       

        if($conexao->error == true){
            echo PHP_EOL."\033[1;31mFalha na conexão!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }else{
            echo PHP_EOL."\033[0;32mConexão realizada com sucesso!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }

        $conexao->close();        
    }

    public function newModel(string $string){
        $this->string = str_replace("mcquery model:", "", $string);
        $this->string = str_replace(" ", "", $this->string);
        $file = model($this->string);
        $namefile = strtolower($this->string);

        if($namefile == ""){
            echo PHP_EOL."\033[1;31mNome do model não informado!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }else{   
            if($namefile == "conexao"){
                echo PHP_EOL."\033[1;31mNão e possivel criar um model com o nome 'conexao'!\033[0m".PHP_EOL.PHP_EOL;
                die();
            }else{
                file_put_contents('Models/'.$this->string.'.php', $file);
                $this->composerUpdate();
                echo PHP_EOL."\033[0;32mModel ( $namefile ) criado com sucesso \033[0m".PHP_EOL.PHP_EOL;
                die();
            }
        }
    }

    public function autoload(){
        shell_exec('composer dumpautoload');        
        echo PHP_EOL."\033[0;32mAutoload atualizado com sucesso\033[0m".PHP_EOL.PHP_EOL;
        die();
    }

    protected function composerUpdate()
    {
        shell_exec('composer dumpautoload');
        return;
    }
}