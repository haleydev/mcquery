<?php
namespace Core;
use Error;
use Throwable;

// tratamento de erros
set_error_handler(function($_errno, $errstr) {    
    throw new Error($errstr);
});

class Template
{
    private $file;

    public function template($template, $params = [])
    {
        $this->file = dirname(__DIR__) . "/./templates/$template.php";

        if (file_exists($this->file)) {
            $template = file_get_contents($this->file);
            $pattern = "/@include(.*)/i";

            if (preg_match_all($pattern, $template, $matches)) {
                foreach ($matches[0] as $include) {
                    $replace = str_replace(['@include(', ')'], "", $include);

                    // verifica se e uma variavel
                    if (str_contains($replace, '$')) {
                        $st = str_replace('$', "", trim($replace));
                        $params_array = json_decode(json_encode($params), true);

                        if (isset($params_array[$st])) {
                            $replace = $params_array[$st];
                        }
                    }

                    $arquivo = $this->include($replace);
                    $template = str_replace($include, $arquivo, $template);

                    if (preg_match_all($pattern, $template, $matches)) {
                        foreach ($matches[0] as $include) {
                            $replace = str_replace(['@include(', ')'], "", $include);

                            // verifica se e uma variavel
                            if (str_contains($replace, '$')) {
                                $st = str_replace('$', "", trim($replace));

                                $params_array = json_decode(json_encode($params), true);
                                if (isset($params_array[$st])) {
                                    $replace = $params_array[$st];
                                }
                            }

                            $arquivo = $this->include($replace);
                            $template = str_replace($include, $arquivo, $template);
                        }
                    }
                }
            }

            return $this->render($template, $params);
        } else {
            die("File not found: " . str_replace(dirname(__DIR__), "", $this->file));
        }
    }

    private function include($include)
    {
        if (file_exists(dirname(__DIR__) . "/./templates/" . trim($include) . ".php")) {
            return file_get_contents(dirname(__DIR__) . "/./templates/" . trim($include) . ".php");
        } else {
            die("File not found: /./templates/" . trim($include) . ".php <br>
            In: " . str_replace(dirname(__DIR__), "", $this->file));
        }
    }

    private function render($template, $params)
    {
        try {
            if ($params != []) {
                return eval('foreach($params as $key => $value) { $$key = $value; } ;?>' . $template);
            } else {
                return eval(";?>" . $template);
            }
        } catch (Throwable $e) {
            echo "Error: " . $e->getMessage() . "<br>";  
        }
    }

    
}
