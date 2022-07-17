<?php
use Core\Env;
use Core\Hashing;
use Core\Http\Redirect;
use Core\Http\Request;
use Core\Template\Template;

/**
 * MCQUERY TEMPLATE
 * @param array|object $params
 * @return Template
 */
function template(array|object $params = [])
{ 
    return new Template($params);
}

/**
 * Redirecionamentos
 */
function redirect($url = null , $response = 302)
{  
    if($url != null) {
       return header('Location: ' . $url, true, $response);
    }

    return new Redirect;
}

/**
 * Converte números para o formato moeda
 * @return string
 */
function money($number ,$c1 = 'pt_BR', $c2 = 'BRL')
{  
    if(!isset($number) or is_null($number) or !is_numeric($number) or $number == false){
        $number = 0;
    }
  
    $formatter = new NumberFormatter($c1,  NumberFormatter::CURRENCY);      
    return $formatter->formatCurrency($number, $c2);
}   

/**
 * Retorna o ultimo erro do validator
 * @return string|false
 */
function validator(string $input)
{
    if(isset($_SERVER['HTTP_REFERER'])){
        $page = $_SERVER['HTTP_REFERER'];

        if(isset($_SESSION['VALIDATOR'][$page]['ERRORS'])){
            if(isset($_SESSION['VALIDATOR'][$page]['ERRORS'][$input])){   
                return $_SESSION['VALIDATOR'][$page]['ERRORS'][$input][0];             
            }        
        }
    }
 
    return false;
}

/**
 * Retorna um array com todos os erros do validator
 * @return array|false
 */
function validator_all()
{ 
    if(isset($_SERVER['HTTP_REFERER'])){
        $page = $_SERVER['HTTP_REFERER']; 

        if(isset($_SESSION['VALIDATOR'][$page]['ERRORS'])){
            if($_SESSION['VALIDATOR'][$page]['ERRORS'] != false){
                $all_errors = $_SESSION['VALIDATOR'][$page]['ERRORS'];      
                $return = [];

                foreach($all_errors as $key => $errors) {          
                    foreach($errors as $erro) {
                        $return[$key] = $erro;
                    }                      
                }

                return $return;
           }
        }
    }   

    return false;
}

/**
 * Retorna o valor do input filtrado por validator
 * @return string|false
 */
function validator_get(string $input)
{
    if(isset($_SERVER['HTTP_REFERER'])){
        $page = $_SERVER['HTTP_REFERER'];

        if(isset($_SESSION['VALIDATOR'][$page]['INPUTS'])){
            if(isset($_SESSION['VALIDATOR'][$page]['INPUTS'][$input])){   
                return $_SESSION['VALIDATOR'][$page]['INPUTS'][$input];             
            }        
        }
    }
 
    return false;
}

/**
 * Retorna o valor declarado em .env
 * @return string|false
 */
function env(string $value)
{
    $env = (new Env)->env;
    if (isset($env[$value])) {
        return $env[$value];
    } 

    return false;    
}

/**
 * Verifica se os valores estao declarados ou vazios em .env
 * @return true|false
 */
function env_required(string|array $values)
{
    $env = (new Env)->env;

    if(is_string($values)){
        if (isset($env[$values])) {
            return true;
        }else{
            return false;
        }
    }

    if(is_array($values)){
        $return = true;
        foreach($values as $value){
            if(!isset($env[$value])){
                $return = false;
            }
        }
        
        return $return;
    }   

    return false; 
}

/**
 * Funções request
 */
function request()
{
    return (new Request);
}

/**
 * Retorna o valor do parâmetro passado em router.
 * @return string|null
 */
function param(string $param)
{
    return Request::param($param);
}

/**
 * Retorna a URL da rota nomeada.
 * Se for uma rota com parâmetros, os parâmetros podem ser especificados como o segundo parâmetro da função
 * separados por , vírgula.
 * @return string|null
 */
function route(string $name, string $params = null)
{
    return Request::route($name,$params);
}

/**
 * Retorna a url procurada não encontrada pelo router.
 * @return string
 */
function router_error()
{
    if (isset($_SESSION['router_error'])) {
        $error = $_SESSION['router_error'];
        unset($_SESSION['router_error']);
        return $error;
    }

    return false;
}

/**
 * Cria uma mensagem de sessão ou a retorna caso não passe nenhum parametro.
 * @param mixed $mesage
 * @return string|false|true
 */
function session_mesage(string|array $mesage = null)
{
    if($mesage === null){         
        if (isset($_SESSION['mcquery_msg'])) {
            $msg = $_SESSION['mcquery_msg']; 
            unset($_SESSION['mcquery_msg']);          
            return $msg;
        }

        return false;    
    }

    $_SESSION['mcquery_msg'] = $mesage; 
    return; 
}

/**
 * Retorna o valor passado em um campo "formulario" anteriormente.
 * @param string $value
 * @return string|array|false
 */
function old(string $input = null)
{  
    $page = request()->url();

    if(!isset($_SESSION['MCQUERY_OLD'][$page])){
        return false;
    }
    
    if (isset($_SESSION['MCQUERY_OLD'][$page][$input])) {
        return $_SESSION['MCQUERY_OLD'][$page][$input];       
    }

    if($input == null and isset($_SESSION['MCQUERY_OLD'][$page])) {
        return $_SESSION['MCQUERY_OLD'][$page];
    }    

    return false;      
}

/**
 * Retorna o token atual.
 * @return string
 */
function token()
{
    if (isset($_SESSION['MCQUERY_TOKEN'])) {
        return $_SESSION['MCQUERY_TOKEN'];
    } else {
        $token = md5("mcquery" . uniqid(microtime()));
        $_SESSION['MCQUERY_TOKEN'] = $token;
        return $token;
    }
}

/**
 * Cria um input token de segurança para formularios.
 * @return string
 */
function token_input()
{    
    return '<input type="hidden" name="mcquery_token" value="'.token().'"/>' . PHP_EOL;
}

/**
 * Desvalida o token atual se existir.
 * @return true
 */
function token_unset()
{
    if (isset($_SESSION['MCQUERY_TOKEN'])) {
        unset($_SESSION['MCQUERY_TOKEN']);
    }

    return true;
}

/**
 * Verifica se a url atual é a mesma que a url passada.
 * Deve ser passado a url completa.
 * @return true|false
 */
function active($url)
{
    $atual =  URL . filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_SANITIZE_URL);
    if ($url == rtrim($atual, "/")) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return var_dump
 */
function dd($what)
{
    echo "<pre>" . PHP_EOL;
    var_dump($what);
    echo "</pre>";
    return;
}

/**
 * Retorna um hash de uma string.
 * @param string $value
 * @return string|false 
 */
function hash_create(string $value)
{
    return (new Hashing)->hash_create($value);
}

/**
 * Verifica se o hash bate com a string, retorna true ou false.
 * @param string $value
 * @param string $hash
 * @return true|false 
 */
function hash_check(string $value, string $hash)
{
    return (new Hashing)->hash_check($value,$hash);
}