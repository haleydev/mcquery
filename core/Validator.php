<?php
namespace Core;

class Validator
{
    private array $request;
    private array $errors = [];

    public function __construct(array $request)
    {
        $this->request = $request;        
    }

    public function required(string $input, $mesage = 'Requerido')
    {
        if(isset($this->request[$input])){
            if($this->request[$input] == '' or $this->request[$input] == false or $this->request[$input] == null){
                $this->errors[$input][] = $mesage;     
            }           
        }else{
            $this->errors[$input][] = $mesage; 
        }
        
        return;
    }

    public function min($input, $min, $mesage = 'Minimo x caracteres') 
    {
        if(isset($this->request[$input])){
            if(strlen($this->request[$input]) < $min){
                if($mesage == 'Minimo x caracteres'){
                    $mesage = 'Minimo '.$min.' caracteres';
                }

                $this->errors[$input][] = $mesage;
            }
        }      
    }

    public function max($input, $max, $mesage = 'Maximo x caracteres') 
    {
        if(isset($this->request[$input])){
            if(strlen($this->request[$input]) > $max){
                if($mesage == 'Maximo x caracteres'){
                    $mesage = 'Maximo '.$max.' caracteres';
                }

                $this->errors[$input][] = $mesage;
            }
        }      
    }

    public function email(string $input, $mesage = 'E-mail inválido')
    {
        if(isset($this->request[$input])){
            if(!filter_var($this->request[$input], FILTER_VALIDATE_EMAIL) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $mesage;
            }
        }
        
        return;
    }

    public function numeric(string $input, $mesage = 'Apenas números')
    {
        if(isset($this->request[$input])){
            if(!is_numeric($this->request[$input]) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $mesage;
            }
        }
        
        return;
    }
    
    /**
     * Faz o registro de erros para serem usados nos templates
     */
    public function register()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            $page = $_SERVER['HTTP_REFERER'];

            if(count($this->errors) > 0) {
                $_SESSION['VALIDATOR_ERRORS'][$page] = $this->errors;
            }else{
                if(isset($_SESSION['VALIDATOR_ERRORS'][$page])){
                    unset( $_SESSION['VALIDATOR_ERRORS'][$page]);
                }
            }
        }       
        
        return;
    }
    
    /**
     * @return array|false
     */
    public function errors(string $input = null)
    {
        if(count($this->errors) > 0) {
            if($input != null) {
                if(isset($this->errors[$input])){
                    return $this->errors[$input];
                }else{
                    return false;
                }
            }

            return $this->errors;
        }

        return false;
    }

    public function error_fist(string $input = null)
    {
        if(count($this->errors) > 0) {           
           if($input == null) {
                foreach($this->errors as $fist) {
                    return $fist[0];
                }
           }else{
                if(isset($this->errors[$input])){
                    return $this->errors[$input][0];
                }else{
                    return false;
                }
           }
        }

        return false;
    }
}