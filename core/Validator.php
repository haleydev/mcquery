<?php
namespace Core;

/**
 * MCQUERY VALIDATOR
 */
class Validator
{
    private array $request;
    private array $errors = [];

    private string $mold_start = '';
    private string $mold_end = '';

    public function __construct(array $request)
    {
        $this->request = $request;        
    }

    /**
     * Requerido
     */
    public function required(string $input, string $mesage = 'Requerido')
    {
        if(isset($this->request[$input])){
            if($this->request[$input] == '' or $this->request[$input] == false or $this->request[$input] == null){
                $this->errors[$input][] = $this->e_mold($mesage);     
            }           
        }else{
            $this->errors[$input][] = $this->e_mold($mesage); 
        }
        
        return;
    }

    /**
     * Minimo de caracteres
     */
    public function min(string $input, int $min, string $mesage = 'Minimo x caracteres') 
    {
        if(isset($this->request[$input])){
            if(strlen($this->request[$input]) < $min){
                if($mesage == 'Minimo x caracteres'){
                    $mesage = 'Minimo ' .$min. ' caracteres';
                }

                $this->errors[$input][] = $this->e_mold($mesage);
            }
        }      
    }

    /**
     * Maximo de caracteres
     */
    public function max(string $input, int $max, string $mesage = 'Maximo x caracteres') 
    {
        if(isset($this->request[$input])){
            if(strlen($this->request[$input]) > $max){
                if($mesage == 'Maximo x caracteres'){
                    $mesage = 'Maximo ' .$max. ' caracteres';
                }

                $this->errors[$input][] = $this->e_mold($mesage);
            }
        }      
    }

    /**
     * Quantidade especifica de caracteres
     */
    public function size(string $input, int $size, string $mesage = 'x caracteres necessários') 
    {
        if(isset($this->request[$input])){
            if(strlen($this->request[$input]) != $size){
                if($mesage == 'x caracteres necessários'){
                    $mesage =  $size . ' caracteres necessários';
                }

                $this->errors[$input][] = $this->e_mold($mesage);
            }
        }      
    }

    /**
     * Valor minimo de um número
     */
    public function min_value(string $input, int|float $min, string $mesage = 'Minimo x') 
    {
        if(isset($this->request[$input])){
            if($this->request[$input] < $min and is_numeric($min) and strlen($this->request[$input]) > 0){
                if($mesage == 'Minimo x') {
                    $mesage = 'Minimo ' . $min;
                }

                $this->errors[$input][] = $this->e_mold($mesage);
            }
        }
        
        return;         
    }

    /**
     * Valor maximo de um número
     */
    public function max_value(string $input, int|float $max, string $mesage = 'Maximo x') 
    {
        if(isset($this->request[$input])){
            if($this->request[$input] > $max and is_numeric($max) and strlen($this->request[$input]) > 0){
                if($mesage == 'Maximo x') {
                    $mesage = 'Maximo ' . $max;
                }

                $this->errors[$input][] = $this->e_mold($mesage);
            }
        }
        
        return;        
    }

    /**
     * Tipo email
     */
    public function email(string $input, string $mesage = 'E-mail inválido')
    {
        if(isset($this->request[$input])){
            if(!filter_var($this->request[$input], FILTER_VALIDATE_EMAIL) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $this->e_mold($mesage);;
            }
        }
        
        return;
    }

    /**
     * Tipo url
     */
    public function url(string $input, string $mesage = 'URL inválido')
    {
        if(isset($this->request[$input])){
            if(!filter_var($this->request[$input], FILTER_VALIDATE_URL) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $this->e_mold($mesage);;
            }
        }
        
        return;
    }

    /**
     * Apenas números
     */
    public function numeric(string $input, string $mesage = 'Apenas números')
    {
        if(isset($this->request[$input])){
            if(!is_numeric($this->request[$input]) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $this->e_mold($mesage);;
            }
        }
        
        return;
    }

    /**
     * Verifica o formato dos números sendo x os números, retorna int ou false
     * @param string $format exemplo (xx) xxxxx-xxxx 
     * @return int|false
     */
    public function number_formart(string $input,string $format, string $mesage = 'Formato inválido x')
    {
        if(isset($this->request[$input]) and strlen($this->request[$input]) > 0){  
            $array_input = str_split($this->request[$input]);
            $array_format = str_split($format);

            $new_input = '';
            $checker = true;
            $return = '';
            
            foreach($array_input as $key => $value) {
                if(is_numeric($value)) {
                    $new_input .= 'x';                   
                }else{
                    $new_input .= $value;
                }

                if(isset($array_format[$key])) {
                    if($array_format[$key] == 'x'){
                        if(!is_numeric($value)){
                            $checker = false;
                        }else{
                            $return .= $value;
                        }
                    }                  
                }else{
                    $checker = false;
                }
            } 

            if($new_input != $format or $checker == false) {
                if($mesage == 'Formato inválido x') {
                    $mesage = 'Formato inválido ' . $format;
                }
                $this->errors[$input][] = $this->e_mold($mesage);
            }else{
                return (int)$return;
            }
        }        
       
        return false;
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
     * Coloca as mensagens de erro entre $start e $end
     */
    public function mold(string $start, string $end)
    {
       $this->mold_start = $start;
       $this->mold_end = $end;
       return;
    }

    private function e_mold(string $input)
    {         
        return $this->mold_start . $input . $this->mold_end;
    }
    
    /**
     * Retorna todos os erros ou false se não existir erros
     * @param strign $input especificar qual item.
     * @return array|string|false
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

     /**
     * Retorna o primeiro erro encontrado
     * @param strign $input especificar qual item.
     * @return array|string|false
     */
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