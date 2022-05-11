<?php
namespace Core;
use Controllers\ErrorController;

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

    private $names = [];
    private $urlrouter = null;
    private $valid = false;
    private $router;
    private $url;

    // validations  
    private $validmethod = null;
    private $validaction = false;
    private $validrouter = false;

    /**
     * @param string $route
     * @param string|callable|array|null $action
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
     * @param string|callable|array|null $action
     */
    public function get(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($this->router == $this->url) {
                $this->validator($action);
                $_SESSION['mcquery_old'] = $_GET;
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|array|null $action
     */
    public function post(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['token']) and isset($_SESSION['token'])) {
                if ($_POST['token'] == $_SESSION['token']) {
                    if ($this->router == $this->url) {
                        if ($this->autoToken == true) {
                            unset_token();
                        }
                        $_SESSION['mcquery_old'] = $_POST;
                        $this->validator($action);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|array|null $action
     */
    public function ajax(string $route, $action = null)
    {
        $this->param($route);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['token']) and isset($_SESSION['token'])) {
                if ($_POST['token'] == $_SESSION['token']) {
                    if ($this->router == $this->url) {
                        $_SESSION['mcquery_old'] = $_POST;
                        $this->validator($action);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param string|callable|array|null $action
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
                    break;
                }
            }
        }

        return $this;
    }

    protected function param($router)
    {
        $this->url = filter_var(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), FILTER_SANITIZE_URL);
        $this->urlrouter = $router;
        $this->router = $router;

        // id url code            
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $this->router, $for_view)) {
            $array_url_view = explode('/', $this->router);
            $array_url_get = explode('/', $this->url);

            if (count($array_url_view) == count($array_url_get)) {
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
                    return;
                } else {
                    if (is_string($this->validaction)) {
                        if (file_exists($this->validaction)) {
                            include_once $this->validaction;
                            $this->valid = true;
                            return;
                        }
                    }

                    if (is_array($this->validaction)) {
                        $this->validaction[0] = new $this->validaction[0]();
                    }

                    if (is_callable($this->validaction)) {
                        call_user_func($this->validaction);
                        $this->valid = true;
                        return;
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
        $this->names[$name] = ROOT . $url;
    }

    protected function validator($action)
    {
        $this->validmethod = true;
        $this->validrouter = $this->router;
        $this->validaction = $action;

        return $this;
    }

    protected function ob_end()
    {
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
        
        die();
    }

    /**
     * Finaliza a execução da rota e retona pagina de erro se a rota não for encontrada.   
     */
   private function end()
    {
        define("routernames", $this->names);

        $this->render();
        
        if ($this->valid == false) {
            $_SESSION['router_error'] = ROOT . $_SERVER['REQUEST_URI'];
            (new ErrorController)->render();
            $this->valid = true;
        }

        if (isset($_SESSION['mcquery_old'])) {          
            unset($_SESSION['mcquery_old']);
        }

        $this->ob_end();
    }

    public function __destruct()
    {
        $this->end();
    }
}