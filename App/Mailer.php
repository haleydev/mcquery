<?php
namespace App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{  
    public $result = false;

    public function send(string $d_email, string $d_name, string $title, $body = null, $anexo = null){
        $check = parse_ini_file("config.ini",true)['php mailer smtp'];
        if(in_array("",$check, true)){
            echo "preencha todas as informacoes necessarias em config.ini";
        }else{
            $config = parse_ini_file("config.ini");     
            $mailer = new PHPMailer;     
            $mailer->isSMTP();
            $mailer->SMTPDebug = 0; //2 para exibir relatorio
            $mailer->Host = $config['mailer_host'];
            $mailer->Port = $config['mailer_port'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $config['mailer_username'];
            $mailer->Password = $config['mailer_password'];

            // informacoes do remetente
            $mailer->setFrom($config['mailer_username'], $config['mailer_name']);
            $mailer->addReplyTo($config['mailer_response'], $config['mailer_name']);
        
            // destinatario
            $mailer->AddAddress("$d_email", "$d_name");       
        
            // titulo do email
            $mailer->Subject = "$title";  
            
            // conteudo do e-mail
            if($body != null){
                $mailer->Body = "$body";
            }  
            
            // ativa html no email
            $mailer->IsHTML(true); 

            // anexo
            if($anexo != null){
                if(file_exists($anexo)){
                    $mailer->addAttachment("$anexo"); 
                }
            }
        
            // envio e resultado
            if($mailer->send()) {
                $this->result = true;
                return true;
            }else{
                $this->result = false;
                return false;
            }
        }
    }
}
