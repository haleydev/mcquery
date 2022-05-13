<?php
namespace Controllers;
use Core\Controller;

class ajaxController extends Controller
{
    public function addCart()
    {  
        // unset($_SESSION['carrinho']);return;
        if(isset($_POST['id']) and isset($_POST['quantidade'])){
            if(is_numeric($_POST['quantidade'])){

                if(isset($_SESSION['carrinho'])){
                    unset($_SESSION['carrinho']['detalhes']);                        
                }else{
                    $_SESSION['carrinho'] = array();
                };
    
                $array = [
                    'id' => $_POST['id'],               
                    'quantidade' => $_POST['quantidade']
                ];
    
                $new_array = array();            
                $total = count($_SESSION['carrinho']); 
                $count = 0;
    
                if($total == 0){
                    $new_array[0] = $array;
                }else{ 
                    foreach($_SESSION['carrinho'] as $value){
                        $checker = true;                  
    
                        if($value['id'] == $_POST['id']){        
                            $checker = false;               
                            $product_total = $_POST['quantidade'] + $value['quantidade'];
                            $new_product = [
                                'id' => $_POST['id'],               
                                'quantidade' => $product_total
                            ];
                           $new_array[$count] = $new_product;
                        }else{
                            $new_product = [
                                'id' => $value['id'],               
                                'quantidade' => $value['quantidade']
                            ];
                           $new_array[$count] = $new_product;                        
                        } 
                        $count++;
                    }
    
                    if($checker == true){
                        $new_product = [
                            'id' => $_POST['id'],               
                            'quantidade' => $_POST['quantidade']
                        ];
                        $new_array[$count] = $new_product;
                    }
                }
    
                $valor_total = $this->totalCart($new_array);
                $itens_total = count($new_array);
    
                $new_array['detalhes'] = [
                    'valor_total' => $valor_total,
                    'itens_total' =>  $itens_total
                ];             
    
                $_SESSION['carrinho'] = $new_array;
                $response = $new_array['detalhes']; 
                               
                return print_r(json_encode($response)); 
            }            
        }
        return false;        
    }

    public function listCart()
    {
        // lista cart lateral aqui
    }

    public function removeCart()
    {
        // remove itens do cart
    }

    private function totalCart(array $itens)
    {
        $total = '99,50';
        return $total;                
    }
}