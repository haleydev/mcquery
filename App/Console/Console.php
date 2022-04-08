<?php
namespace App\Console;
use App\Conexao;

class Console
{
    private $comand;   
    private $render = false;    

    public function __construct()
    {        
        $string = "";
        global $argv;        
        foreach($argv as $console){
            $string.= $console. " ";
        }
        $this->comand = trim($string);        
    }

    public function reader()
    {        
        if($this->comand == 'mcquery'){
            $this->render = true;
            $this->dashboard();
            die();
        }      

        if($this->comand == 'mcquery env'){
            $this->render = true;
            echo PHP_EOL."\033[1;31mSubstituir o .env atual ? (s/n)\033[0m".PHP_EOL.PHP_EOL;
            $console_env = (string)readline('');
            if($console_env == 's'){
                $this->newEnv();               
            }else{
                echo PHP_EOL."\033[1;31mOperação cancelada\033[0m".PHP_EOL.PHP_EOL;                   
                die();
            }
        }

        if($this->comand == 'mcquery conexao'){
            $this->render = true;
            $this->conexao();                
        }

        if($this->comand == 'mcquery install'){
            $this->render = true;
            $this->composerInstall();                
        }

        if($this->comand == 'mcquery autoload'){
            $this->render = true;
            shell_exec('composer dumpautoload');        
            echo PHP_EOL."\033[0;32mAutoload atualizado com sucesso\033[0m".PHP_EOL.PHP_EOL;                
            die();
        }
            
        if(strpos($this->comand,'mcquery controller:') === 0){
            $this->render = true;
            $controller_s = str_replace("mcquery controller:", "", $this->comand);
            $controller_s = str_replace(" ", "", $controller_s);
            $this->newController($controller_s);
        } 

        if(strpos($this->comand,'mcquery model:') === 0){
            $this->render = true;
            $controller_m = str_replace("mcquery model:", "", $this->comand);
            $controller_m = str_replace(" ", "", $controller_m);
            $this->newModel($controller_m);
        } 

        // fim do reader
        if($this->render == false){
            echo PHP_EOL."\033[1;31mComando inválido!\033[0m".PHP_EOL.PHP_EOL;
            die();
        }        
    }

    private function dashboard()
    {   
        echo "\033[1;34m 
 mcquery v0.5.0
 _ __ ___   ___ __ _ _   _  ___ _ __ _   _ 
 | '_ ` _ \ / __/ _` | | | |/ _ \ '__| | | |
 | | | | | | (_| (_| | |_| |  __/ |  | |_| |
 |_| |_| |_|\___\__, |\__,_|\___|_|   \__, |
                   |_|                |___/  
        \033[0m".PHP_EOL;
        echo "\033[0;32m controller:Nome\033[0m cria um novo controller, adicione 'pasta/NomeController' caso queira adicionar uma subpasta".PHP_EOL;  
        echo "\033[0;32m model:Nome\033[0m cria um novo model".PHP_EOL.PHP_EOL;   
        echo "\033[0;32m env\033[0m cria um novo arquivo de configurações (.env)".PHP_EOL;   
        echo "\033[0;32m conexao\033[0m testa a conexão com o banco de dados".PHP_EOL; 
        echo "\033[0;32m autoload\033[0m atualiza o autoload de classes".PHP_EOL;         
        echo "\033[0;32m install\033[0m instala as dependências do composer".PHP_EOL;   
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
            echo "\033[1;31mNome do controller não informado!\033[0m".PHP_EOL;
            die();
        }else{
            if(!preg_match("/^[a-zA-Z ]*$/", $nameclass)){
                echo "\033[1;31mNome do controller invalido!\033[0m".PHP_EOL;               
                die();
            }
            $file = controller($nameclass,$namespace);

            $confirm = true;
            if(file_exists("Controllers/$folder$nameclass.php")){
                echo "\033[1;31mSubstituir controller '$nameclass' ? (s/n)\033[0m".PHP_EOL;
                $console = (string)readline('');
                if($console == 's'){
                    $confirm == true;                   
                }else{
                    echo "\033[1;31mOperação cancelada\033[0m".PHP_EOL;
                    $confirm == false;
                    die();
                }
            }

            if($nameclass == 'Controller' or $nameclass == 'controller'){
                echo "\033[1;31mEste nome de controller não pode ser usado\033[0m".PHP_EOL;
            }else{
                if($confirm == true){
                    file_put_contents('Controllers/'.$folder.''.$nameclass.'.php', $file);
                    $this->composerUpdate();
                    echo "\033[0;32mController ( $nameclass ) criado com sucesso \033[0m".PHP_EOL;
                    die();
                }
            }            
        }
    }

    private function newModel(string $string)
    {
        $file = model($string);
        $namefile = strtolower($string);

        if($namefile == ""){
            echo "\033[1;31mNome do model não informado!\033[0m".PHP_EOL;
            die();
        }else{              
            if(!preg_match("/^[a-zA-Z ]*$/", $string)){
                echo "\033[1;31mNome do model invalido!\033[0m".PHP_EOL;               
                die();
            }
            
            $confirm = true;
            if(file_exists("Models/$namefile.php")){
                echo "\033[1;31mSubstituir model '$string' ? (s/n)\033[0m".PHP_EOL;
                $console = (string)readline('');
                if($console == 's'){
                    $confirm == true;                   
                }else{
                    echo "\033[1;31mOperação cancelada\033[0m".PHP_EOL;
                    $confirm == false;
                    die();
                }
            }   

            if($confirm == true){
                file_put_contents('Models/'.$string.'.php', $file);
                $this->composerUpdate();
                echo "\033[0;32mModel ( $string ) criado com sucesso \033[0m".PHP_EOL;
                die();
            }           
        }
    }

    private function newEnv()
    {
        $file = new_env(); 
        file_put_contents('.env', $file);
        
        echo "\033[0;32m.ini criado com sucesso \033[0m".PHP_EOL;
        die();
    }

    private function conexao()
    {
        $conexao = new Conexao;
        $conexao->pdo();
        $conexao->conect;       

        if($conexao->error == true){
            echo "\033[1;31mFalha na conexão!\033[0m".PHP_EOL;            
        }else{
            echo "\033[0;32mConexão realizada com sucesso\033[0m".PHP_EOL;            
        }        
        $conexao->close();  
        die();      
    }

    private function composerInstall(){
        shell_exec('composer install');
        echo "\033[0;32mDependências do composer instaladas com sucesso\033[0m".PHP_EOL;
        die();
    }

    private function composerUpdate()
    {
        shell_exec('composer dumpautoload');
        return;
    }  
}