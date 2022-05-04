<?php
use Core\Env;
use Core\Hashing;
use Core\Template;

$array_env = (new Env)->env;
// retorna o valor declarado em .env
function env(string $value)
{
    global $array_env;
    if (array_key_exists($value, $array_env)) {
        return $array_env[$value];
    } else {
        return null;
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
function get(string $id)
{
    if (defined('routerget')) {
        if (array_key_exists($id, routerget)) {
            return routerget[$id];
        } else {
            return null;
        }
    }
}

/**
 * Retorna a URL da rota nomeada.
 * Se for uma rota com parâmetros, os parâmetros podem ser especificados como o segundo parâmetro da função
 * separados por , vírgula.
 * @return string|null
 */
function router(string $name, string $params = null)
{
    if (defined('routernames')) {
        if (array_key_exists($name, routernames)) {
            if ($params != null) {
                $arrayrouter = explode('/', routernames[$name]);
                $arrayparams = explode(',', $params);
                $paramsn = 0;
                $tringr = "";

                foreach ($arrayrouter as $key) {
                    if ($key == "{id}") {
                        $tringr .= $arrayparams[$paramsn] . "/";
                        $paramsn++;
                    } else {
                        $tringr .= $key . "/";
                    }
                }

                return rtrim($tringr, "/");
            } else {
                return rtrim(routernames[$name], "/");
            }
        } 
    }

    return null;
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
}

/**
 * Cria uma mensagem de sessão ou a retorna caso nao passe nenhum parametro.
 * @param mixed $mesage
 * @return string|false|true
 */
function session_mesage($mesage = null)
{
    if($mesage === null){         
        if (isset($_SESSION['mcquery_msg'])) {
            $msg = $_SESSION['mcquery_msg']; 
            unset($_SESSION['mcquery_msg']);          
            return $msg;
        }else{
            return false;
        }
    }else{
        $_SESSION['mcquery_msg'] = $mesage;
        return true;
    }
}

/**
 * Retorna o valor passado em um formulario anteriormente.
 * @param string $value
 * @return string|false
 */
function old($value)
{    
    if (isset($_SESSION['mcquery_old'][$value])) {
        $old = $_SESSION['mcquery_old'][$value];
        return $old;
    }else{
        return false;
    }    
}

/**
 * Cria um token de segurança para formularios.
 * @return string
 */
function validate()
{
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
    } else {
        $token = md5("9856b" . uniqid(microtime()));
    }
    $_SESSION['token'] = $token;
    echo "<input type='hidden' name='token' value='$token'/>" . PHP_EOL;
    return;
}

/**
 * Retorna o token atual.
 * @return string
 */
function token()
{
    if (isset($_SESSION['token'])) {
        return $_SESSION['token'];
    } else {
        $token = md5("9856b" . uniqid(microtime()));
        $_SESSION['token'] = $token;
        return $token;
    }
}

/**
 * Desvalida o token atual se existir.
 * @return true
 */
function unset_token()
{
    if (isset($_SESSION['token'])) {
        unset($_SESSION['token']);
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
    $atual =  ROOT . filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_SANITIZE_URL);
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
function redirect($url, $statusCode = 303)
{  
    header("Location: $url",TRUE,$statusCode);
    die();
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