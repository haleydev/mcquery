<?php
// renderiza uma view
function view(string $view){
    $file = './Templates/views/'.$view.'.php';
    if(file_exists($file)){        
        require $file;                               
    }else{
        echo "view não encontrada";
        return;
    }
}

// retorna o valor do parâmetro passado em router
function get($id){
    if(defined('routerget')){ 
        if(array_key_exists($id,routerget)){
            return routerget[$id];
        }else{
            return "parametro não encontrado";
        }
    } 
}

// retorna a URL da rota nomeada
// se for uma rota com parâmetros, os parâmetros podem ser especificados como o segundo parâmetro da função
function router($name, $params = null){
    if(defined('routernames')){
        if(array_key_exists($name,routernames)){
            if($params != null){
                $arrayrouter = explode('/',routernames[$name]); 
                $arrayparams = explode(',',$params);
                $paramsn = 0;
                $tringr = "";   

                foreach($arrayrouter as $key){
                    if($key == "{id}"){
                        $tringr.=$arrayparams[$paramsn]."/";
                        $paramsn++;
                    }else{
                        $tringr.=$key."/";
                    } 
                }    
                   
                return rtrim($tringr,"/") ;      
            }else{
                return routernames[$name];
            }
        }else{
            return false;
        }
    }
} 

// retorna a url procurada nao encontrada pelo router
function routerError(){
    if(isset($_SESSION['router_error'])){
        $error = $_SESSION['router_error'];
        unset($_SESSION['router_error']);
        return $error;
    }
}

// cria um token para segurança de formularios
function validate(){
    if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
    }else{
        $token = md5("9856b".uniqid(microtime())); 
    }    
    $_SESSION['token'] = $token;   
    echo "<input type='hidden' name='token' value='$token'/>".PHP_EOL;  
    return;   
}

// retorna o token atual
function token(){
    if(isset($_SESSION['token'])){        
        return $_SESSION['token'];
    }else{
        $token = md5("9856b".uniqid(microtime()));  
        $_SESSION['token'] = $token;
        return $token;
    }
}

// remove o token da sessão
function unsetToken(){
    if(isset($_SESSION['token'])){        
        unset($_SESSION['token']);
    }return;
}

// checa se o post existe e se o valor e valido
// pode ser passado varios post separados por ,
function postCheck($post){
    $return = true;
    $array = explode(",",$post);
    foreach ($array as $valid) {
        if(isset($_POST[$valid])){           
            if($_POST[$valid] == null or $_POST[$valid] == ""){
                $return = false; 
            }
        }else{
            $return = false;           
        }   
    }
    return $return;
}

// checa se o get existe e se o valor e valido
// pode ser passado varios get separados por ,
function getCheck($get){
    $return = true;
    $array = explode(",",$get);
    foreach ($array as $valid) {
        if(isset($_GET[$valid])){           
            if($_GET[$valid] == null or $_GET[$valid] == ""){
                $return = false; 
            }
        }else{
            $return = false;           
        }   
    }
    return $return;
}

// verifica se a url atual é a mesma que a url passada
// deve ser passado a url completa
function active($url){    
    $atual =  URL."/".filter_var(filter_input(INPUT_GET,"url", FILTER_DEFAULT),FILTER_SANITIZE_URL);
    if($url == rtrim($atual, "/")){
        return true;
    }else{
        return false;	
    }
}