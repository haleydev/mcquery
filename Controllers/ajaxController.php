<?php
namespace Controllers;
use Core\Controller;

class ajaxController extends Controller
{
    public function session()
    {  
        if(post_check('id,quantidade')){
            if(!isset($_SESSION['teste'])){
                $_SESSION['teste'] = array();
            }; 

            $array = [
                'id' => $_POST['id'],               
                'quantidade' => $_POST['quantidade']
            ];

            $new_array = array();            
            $total = count($_SESSION['teste']); 
            $count = 0;

            if($total == 0){
                $new_array[0] = $array;
            }else{ 
                foreach($_SESSION['teste'] as $value){
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

            $_SESSION['teste'] = $new_array;
            
            return dd($_SESSION['teste']);    
        }else{
            return false;
        }; 
    }
}