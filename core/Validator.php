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
    public function required(string $input, $mesage = 'Requerido')
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
    public function min($input, $min, $mesage = 'Minimo x caracteres') 
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
    public function max($input, $max, $mesage = 'Maximo x caracteres') 
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
     * Tipo email
     */
    public function email(string $input, $mesage = 'E-mail inválido')
    {
        if(isset($this->request[$input])){
            if(!filter_var($this->request[$input], FILTER_VALIDATE_EMAIL) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $this->e_mold($mesage);;
            }
        }
        
        return;
    }

    /**
     * Apenas números
     */
    public function numeric(string $input, $mesage = 'Apenas números')
    {
        if(isset($this->request[$input])){
            if(!is_numeric($this->request[$input]) and strlen($this->request[$input]) > 0){
                $this->errors[$input][] = $this->e_mold($mesage);;
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