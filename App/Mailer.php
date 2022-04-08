<?php
namespace App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{  
    public $result = false;

    public function send(string $d_email, string $d_name, string $title, $body = null, $anexo = null)
    {    
        if(env_required('mailer_name,mailer_response,mailer_host,mailer_port,mailer_username,mailer_password')){

            $mailer = new PHPMailer;     
            $mailer->isSMTP();
            $mailer->SMTPDebug = 0; //2 para exibir relatorio
            $mailer->Host = env('mailer_host');
            $mailer->Port = env('mailer_port');
            $mailer->SMTPAuth = true;
            $mailer->Username = env('mailer_username');
            $mailer->Password = env('mailer_password');

            // informacoes do remetente
            $mailer->setFrom(env('mailer_username'), env('mailer_name'));
            $mailer->addReplyTo(env('mailer_response'), env('mailer_name'));
        
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
        }else{
            echo "Preencha todos os campos necessários em .env";
        }
    }
}