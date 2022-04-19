<?php
namespace App;

/**
 * O lindo e complexo gerenciador de rotas do mcquery.
 */

class Router
{
    /**
     * False: será necessário usar a função unsetToken() logo após a validação do formulário para manter a segurança.
     * True: o token será redefinido ao enviar um formulário automaticamente.
     * @param boolean $autoToken
     */
    public $autoToken = true;

    private array $names;
    private $urlrouter = null;
    private $valid = false;
    private $router;
    private $url;

    // validations  
    private $validmethod = null;
    private $validaction = false;
    private $validrouter = false;

    public function __construct()
    {        
        $this->url = filter_var(filter_input(INPUT_GET, "url", FILTER_DEFAULT), FILTER_SANITIZE_URL);
    }

    /**
     * @param string $route
     * @param string|callable|null $action
     */
    public function url(string $route, $action = null)
    {
        $this->param($route);
        if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) == NULL) {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                if ($this->router == $this->url) {
                    $this->validator($action);
                }
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|null $action
     */
    public function get(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($this->router == $this->url) {
                $this->validator($action);
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|null $action
     */
    public function post(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['token']) and isset($_SESSION['token'])) {
                if ($_POST['token'] == $_SESSION['token']) {
                    if ($this->router == $this->url) {
                        if ($this->autoToken == true) {
                            unsetToken();
                        }
                        $this->validator($action);
                    }
                }
            } else {
                echo "Token de seguranca não definido";
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|null $action
     */
    public function ajax(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['token']) and isset($_SESSION['token'])) {
                if ($_POST['token'] == $_SESSION['token']) {
                    if ($this->router == $this->url) {
                        $this->validator($action);
                    }
                }
            } else {
                echo "Token de seguranca não definido";
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|null $action
     * @param string $method     
     */
    public function api(string $route, $action = null, string $methods)
    {
        $this->param($route);
        if ($this->router == $this->url) {
            header("Content-Type:application/json");
            $array_methods = explode(',', strtoupper($methods));
            foreach ($array_methods as $mt) {
                if ($_SERVER['REQUEST_METHOD'] == $mt) {
                    $this->validator($action);
                }
            }
        }

        return $this;
    }

    protected function param($router)
    {
        $this->urlrouter = substr($router, 1);
        $this->router = substr($router, 1);

        // id url code            
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $this->router, $for_view)) {

            $array_url_view = explode('/', $this->router);
            $array_url_get = explode('/', $this->url);

            if (count($array_url_view) == count($array_url_get) and !in_array(null, $array_url_get)) {               
                $new_url = "";
                $array_define = array();
                foreach ($for_view[0] as $variable) {                  
                    if ($new_url != null) {
                        $array_url_view = explode('/', $new_url);
                    }
                    $url_key = array_search($variable, $array_url_view);
                    $key_view = $array_url_get[$url_key];

                    $replacement = array($url_key => $key_view);
                    $replace_array_url = array_replace($array_url_view, $replacement);
                    $new_url = implode("/", $replace_array_url);
                    $id_view = $array_url_view[$url_key];

                    if (preg_match_all($patternVariable, $id_view, $define_view)) {
                        $defid_url = $key_view;
                    }
                    $array_define[$define_view[1][0]] = $defid_url;
                }

                define("routerget", $array_define);

                if ($new_url == $this->url) {
                    $this->router = $new_url;
                }
            }
        }

        return $this;
    }

    protected function render()
    {
        if ($this->validmethod == true) {
            if ($this->validrouter == $this->url) {
                if ($this->validaction == null) {
                    $this->valid = true;
                    ob_end_flush();
                    return;
                } else {
                    if (is_callable($this->validaction)) {
                        // function detect                     
                        call_user_func($this->validaction);
                        $this->valid = true;
                        ob_end_flush();
                        return;
                    } else {
                        if (file_exists($this->validaction)) {
                            include_once $this->validaction;
                            $this->valid = true;
                            ob_end_flush();
                            return;
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Nome da rota
     * @param string $name  
     */
    public function name($name = null)
    {
        if (str_contains($this->urlrouter, '{')) {
            $array_url_view = explode('/', $this->urlrouter);
            $string = "";
            foreach ($array_url_view as $variable) {
                if (!str_contains($variable, '{')) {
                    $string .= $variable . "/";
                } else {
                    $string .= "{id}" . "/";
                }
            }
            $url = $string;
        } else {
            $url = $this->router;
        }
        $this->names[$name] = rtrim(ROOT . "/" . $url, "/");
    }

    protected function validator($action)
    {
        $this->validmethod = true;
        $this->validrouter = $this->router;
        $this->validaction = $action;

        return $this;
    }

    /**
     * Finaliza a execução da rota e retona pagina de erro se a rota não for encontrada.   
     */
    public function end()
    {
        define("routernames", $this->names);
        $this->render();
        if ($this->valid == false) {
            $_SESSION['router_error'] = ROOT . "/" . $this->url;
            header("Location:" . router('erro'));
            ob_end_flush();
            return $this->valid = true;
            die;
        } else {
            ob_end_flush();
            die;
        }
    }
}