<?php
namespace App;

class System
{      
    // true: o token será redefinido ao enviar um formulário automaticamente
    // false: será necessário usar a função unsetToken() logo após a validação do formulário para manter a segurança
    public $autoToken = true;

    private array $names;
    private $urlrouter = null;
    protected $valid = false;
    private $router;     
    private $url;    
    
    // validations  
    private $validmethod = null;
    private $validaction = false;
    private $validrouter = false;  

    public function __construct()
    {
        $this->url = filter_var(filter_input(INPUT_GET,"url", FILTER_DEFAULT),FILTER_SANITIZE_URL);         
    }
         
    public function url(string $router, $action)
    {
        $this->router($router, $action);
        if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) == NULL){
            if($_SERVER['REQUEST_METHOD'] == "GET"){
                if($this->router == $this->url){
                    $this->validator($action);
                }                
            }
        } return $this;        
    }

    public function get(string $router, $action)
    {    
        $this->router($router, $action);  
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            if($this->router == $this->url){              
                $this->validator($action);
            }
        } return $this;        
    }
    
    public function post(string $router, $action)
    {
        $this->router($router, $action);  
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['token']) and isset($_SESSION['token'])){
                if($_POST['token'] == $_SESSION['token']){
                    if($this->router == $this->url){
                        if($this->autoToken == true){
                            unsetToken();
                        }                        
                        $this->validator($action);
                    }                                    
                }
            }else{
                echo "Token de seguranca não definido"; 
            }            
        } return $this;        
    }

    public function ajax(string $router, $action)
    {
        $this->router($router, $action);  
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['token']) and isset($_SESSION['token'])){
                if($_POST['token'] == $_SESSION['token']){
                    if($this->router == $this->url){                                        
                        $this->validator($action);
                    }                                    
                }
            }else{
                echo "Token de seguranca não definido"; 
            }            
        } return $this;        
    }

    public function api(string $router, $action, string $methods)
    {
        $this->router($router, $action);
        if($this->router == $this->url){ 
            header("Content-Type:application/json");             
            $array_methods = explode(',',strtoupper($methods));  
            foreach($array_methods as $mt){
                if($_SERVER['REQUEST_METHOD'] == $mt){
                    $this->validator($action);
                }
            }            
        } return $this;
    }

    protected function router($router, $action)
    {          
        $this->urlrouter =$router; 
        $this->router = $router;      
        
        // id url code            
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable,$this->router,$for_view)){ 
                            
            $array_url_view = explode('/',$this->router);
            $array_url_get = explode('/',$this->url); 

            if(count($array_url_view) == count($array_url_get) and !in_array(null,$array_url_get)){
                $new_url = "";
                $array_define = array();
                foreach($for_view[0] as $variable){                    
                    if($new_url != null){
                        $array_url_view = explode('/',$new_url);
                    }
                    $url_key = array_search($variable, $array_url_view);
                    $key_view = $array_url_get[$url_key];
                   
                    $replacement = array($url_key => $key_view);
                    $replace_array_url = array_replace($array_url_view, $replacement);
                    $new_url = implode("/", $replace_array_url); 
                    $id_view = $array_url_view[$url_key];  

                    if(preg_match_all($patternVariable,$id_view,$define_view)){
                        $defid_url = $key_view; 
                    }
                    $array_define[$define_view[1][0]] = $defid_url;
                }               

                define("routerget",$array_define);

                if($new_url == $this->url){
                    $this->router = $new_url;          
                }                    
            }                         
        } return $this;              
    } 

    protected function render()
    {       
        if($this->validmethod == true){
            if($this->validrouter == $this->url){           
                if(is_callable($this->validaction)){
                    // function detect                     
                    call_user_func($this->validaction);                     
                    $this->valid = true;
                    ob_end_flush();
                    return;
                }else{
                    if(file_exists($this->validaction)){        
                        include_once $this->validaction; 
                        $this->valid = true;   
                        ob_end_flush();
                        return;                   
                    }
                }
            } 
        } return $this;
    }

    public function name($name = null)
    {
        if(str_contains($this->urlrouter, '{')){
            $array_url_view = explode('/',$this->urlrouter);
            $string = "";
            foreach($array_url_view as $variable){
                if(!str_contains($variable, '{')) {
                    $string .= $variable."/";	
                }else{
                    $string .= "{id}"."/";
                }
            }
            $url = $string; 
        }else{
            $url = $this->router;
        }
        $this->names[$name]= rtrim(URL."/".$url,"/");
    }

    protected function validator($action)
    {
        $this->validmethod = true;
        $this->validrouter = $this->router;
        $this->validaction = $action;
        return $this;
    }

    public function end()
    { 
        define("routernames",$this->names);        
        $this->render();        
        if($this->valid == false){               
            $_SESSION['router_error'] = URL."/". $this->url;
            header("Location:".router('error'));
            ob_end_flush();              
            return $this->valid = true; 
            die;                 
        }else{
            ob_end_flush(); 
            die; 
        }         
    }
}