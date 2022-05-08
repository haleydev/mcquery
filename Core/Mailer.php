<?php
namespace Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    /**
     * Resultado do envio. 
     * @return true|false
     */
    public $result = false;
    
    /**
     * Email do destinatario.
     * @param $email
     */
    public $email;

    /**
     * Nome do destinatario.
     * @param $name
     */
    public $name;

    /**
     * Titulo do email.
     * @param $title
     */
    public $title;

    /**
     * Corpo do email.
     * @param $body
     */
    public $body = null;

    /**
     * Enexo do email 'opcional'.
     * @param $anexo
     */
    public $anexo = null;    

    /**
     * Envia as informacoes do email para o destinatario.   
     */
    public function send()
    {
        if (env_required('MAILER_NAME,MAILER_RESPONSE,MAILER_HOST,MAILER_PORT,MAILER_USERNAME,MAILER_PASSWORD')) {
            $mailer = new PHPMailer;
            $mailer->isSMTP();
            $mailer->SMTPDebug = 0; //2 para exibir relatorio
            $mailer->Host = env('MAILER_HOST');
            $mailer->Port = env('MAILER_PORT');
            $mailer->SMTPAuth = true;
            $mailer->Username = env('MAILER_USERNAME');
            $mailer->Password = env('MAILER_PASSWORD');

            // informacoes do remetente
            $mailer->setFrom(env('MAILER_USERNAME'), env('MAILER_NAME'));
            $mailer->addReplyTo(env('MAILER_RESPONSE'), env('MAILER_NAME'));

            // destinatario
            $mailer->AddAddress($this->email, $this->name);

            // titulo do email
            $mailer->Subject = $this->title;

            // conteudo do e-mail
            if ($this->body != null) {
                $mailer->Body = $this->body;
            }

            // ativa html no email
            $mailer->IsHTML(true);

            // anexo
            if ($this->anexo != null) {
                if (file_exists($this->anexo)) {
                    $mailer->addAttachment("$this->anexo");
                }
            }

            // envio e resultado
            if ($mailer->send()) {
                $this->result = true;
                return true;
            } else {
                $this->result = false;
                return false;
            }
        } else {
            echo "Preencha todos os campos necessários em .env";
        }
    }
}