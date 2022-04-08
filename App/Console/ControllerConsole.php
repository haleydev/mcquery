<?php
namespace App\Console;
use App\Conexao;

class ControllerConsole
{
    protected $string;

    public function dashboard()
    {
        echo PHP_EOL;
        echo "\033[1;34mBem vindo ao mcquery\033[0m".PHP_EOL.PHP_EOL;    
        echo "\033[1;32mComandos".PHP_EOL;   
        echo "\033[1;93menv\033[0m cria o arquivo de configurações (.env) e instala dependências".PHP_EOL;   
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

            $confirm = true;
            if(file_exists("Controllers/$folder$nameclass.php")){
                $console = (string)readline(PHP_EOL."\033[1;31mSubstituir controller '$nameclass' ? (s/n)\033[0m");
                if($console == 's'){
                    $confirm == true;                   
                }else{
                    echo PHP_EOL."\033[1;31mOperação cancelada\033[0m".PHP_EOL.PHP_EOL;
                    $confirm == false;
                    die();
                }
            }

            if($confirm == true){
                file_put_contents('Controllers/'.$folder.''.$nameclass.'.php', $file);
                $this->composerUpdate();
                echo PHP_EOL."\033[0;32mController ( $nameclass ) criado com sucesso \033[0m".PHP_EOL.PHP_EOL;
                die();
            }
        }
    }

    public function newModel(string $string)
    {
        $this->string = str_replace("mcquery model:", "", $string);
        $this->string = str_replace(" ", "", $this->string);
        $file = model($this->string);
        $namefile = strtolower($this->string);

        if($namefile == ""){
            echo PHP_EOL."\033[1;31mNome do model não informado!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }else{ 
            $confirm = true;
            if(file_exists("Models/$namefile.php")){
                $console = (string)readline(PHP_EOL."\033[1;31mSubstituir model '$this->string' ? (s/n)\033[0m");
                if($console == 's'){
                    $confirm == true;                   
                }else{
                    echo PHP_EOL."\033[1;31mOperação cancelada\033[0m".PHP_EOL.PHP_EOL;
                    $confirm == false;
                    die();
                }
            }
            if($confirm == true){
                file_put_contents('Models/'.$this->string.'.php', $file);
                $this->composerUpdate();
                echo PHP_EOL."\033[0;32mModel ( $this->string ) criado com sucesso \033[0m".PHP_EOL.PHP_EOL;
                die();
            }           
        }
    }

    public function conexao()
    {
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

    public function autoload()
    {
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