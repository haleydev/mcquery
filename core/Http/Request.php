<?php
namespace Core\Http;

class Request
{
    /**
     * Retorna o valor do parâmetro passado em router.
     * @return string|false
     */
    public static function param(string $param)
    {
        if (defined('ROUTER_PARAMS') and ROUTER_PARAMS != null) {
            if (array_key_exists($param, ROUTER_PARAMS)) {
                return urldecode(ROUTER_PARAMS[$param]);
            } else {
                return false;
            }
        }

        return false;
    }

    public static function route(string $name, string $params = null)
    { 
        if (defined('ROUTER_NAMES')) {
            if (isset(ROUTER_NAMES[$name])) {
                if ($params != null) {
                    $arrayrouter = explode('/', ROUTER_NAMES[$name]);
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
                    return rtrim(ROUTER_NAMES[$name], "/");
                }
            }
        }

        return false;
    }

    public static function get(string|array|null $get = null)
    {
        if ($get === null) {
            if ($_GET == null) {
                return false;
            }

            return filter_input_array(INPUT_GET, $_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if (is_array($get)) {
            $return = array();
            foreach ($get as $valid) {
                if (isset($_GET[$valid])) {
                    if ($_GET[$valid] == null or $_GET[$valid] == "") {
                        return false;
                    } else {
                        $return[$valid] = filter_input(INPUT_GET, $valid, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                } else {
                    return false;
                }
            }

            return $return;
        }

        if (is_string($get)) {
            if (isset($_GET[$get])) {
                if ($_GET[$get] == null or $_GET[$get] == "") {
                    return false;
                } else {
                    return filter_input(INPUT_GET, $get, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }

        return false;
    }

    public static function post(string|array|null $post = null)
    {
        if ($post === null) {
            if ($_POST == null) {
                return false;
            }

            return filter_input_array(INPUT_POST, $_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if (is_array($post)) {
            $return = array();
            foreach ($post as $valid) {
                if (isset($_POST[$valid])) {
                    if ($_POST[$valid] == null or $_POST[$valid] == "") {
                        return false;
                    } else {
                        $return[$valid] = filter_input(INPUT_POST, $valid, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                } else {
                    return false;
                }
            }

            return $return;
        }

        if (is_string($post)) {
            if (isset($_POST[$post])) {
                if ($_POST[$post] == null or $_POST[$post] == "") {
                    return false;
                } else {
                    return filter_input(INPUT_POST, $post, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }

        return false;
    }

    public static function url()
    {
        $request = parse_url($_SERVER['REQUEST_URI']);
        $url = rtrim(URL . $request['path'], "/");
        return $url;
    }

    public static function urlFull()
    {
        $fullUrl = URL . $_SERVER['REQUEST_URI'];
        return rtrim($fullUrl, '/');
    }

    public static function getReplace(array $getReplace)
    {
        $gets = filter_input_array(INPUT_GET, $_GET, FILTER_SANITIZE_SPECIAL_CHARS);
        foreach ($getReplace as $key => $value) {
            $gets[$key] = $value;
        }

        $allGets = http_build_query($gets);

        if ($allGets == "") {
            return self::url();
        } else {
            return self::url() . '?' . $allGets;
        }
    }

    public static function redirect($route, $code = 200)
    {
        header('Location: ' . $route, true, $code);
        die;
    }
}
