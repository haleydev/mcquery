<?php
use Core\Env;
use Core\Hashing;
use Core\Http\Request;
use Core\Template;

// retorna o valor declarado em .env
function env(string $value)
{
    $env = (new Env)->env;
    if (isset($env[$value])) {
        return $env[$value];
    } else {
        return false;
    }
}

// verifica se os valores estao declarados ou vazios em .env retornando true ou false
function env_required(string $values)
{
    global $array_env;
    $result = true;
    $array = explode(',', $values);
    foreach ($array as $key) {
        if (!array_key_exists($key, $array_env)) {
            $result = false;
        } else {
            if ($array_env[$key] == null) {
                $result = false;
            }
        }
    }
    return $result;
}

/**
 * Renderiza um template.
 * @param string $template
 * @param array|object $params
 * @return template
 */
function template(string $template, array|object $params = [])
{ 
    return (new Template)->template($template,$params);
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
    if (isset($_SESSION['MCQUERY_OLD'][$input])) {
        return $_SESSION['MCQUERY_OLD'][$input];       
    }

    if($input == null and isset($_SESSION['MCQUERY_OLD'])) {
        return $_SESSION['MCQUERY_OLD'];
    }

    return false;      
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
 * Desvalida o token atual se existir.
 * @return true
 */
function unset_token()
{
    if (isset($_SESSION['MCQUERY_TOKEN'])) {
        unset($_SESSION['MCQUERY_TOKEN']);
    }

    return true;
}

/**
 * Checa se o $_POST existe e se seu valor e nulo
 * Pode ser passado varios $_POST separados por ,
 * @return true|false
 */
function post_check(string $post)
{
    $return = true;
    $array = explode(",", $post);
    foreach ($array as $valid) {
        if (isset($_POST[$valid])) {
            if ($_POST[$valid] == null or $_POST[$valid] == "") {
                $return = false;
            }
        } else {
            $return = false;
        }
    }
    return $return;
}

/**
 * Checa se o $_GET existe e se seu valor e nulo
 * Pode ser passado varios $_GET separados por ,
 * @return true|false
 */
function get_check(string $get)
{
    $return = true;
    $array = explode(",", $get);
    foreach ($array as $valid) {
        if (isset($_GET[$valid])) {
            if ($_GET[$valid] == null or $_GET[$valid] == "") {
                $return = false;
            }
        } else {
            $return = false;
        }
    }
    return $return;
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
 * Redirecionar para a $url 
 */
function redirect($route, $code = 200)
{
    Request::redirect($route,$code);
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