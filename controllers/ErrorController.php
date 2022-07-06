<?php
namespace Controllers;
use Core\Http\Request;

class ErrorController
{
    public function error($code = 404, $msg = null)
    {      
        $_SESSION['router_error'] = Request::url();
       
        if ($msg === null) {
            switch ($code):
                case 302:
                    $this->msg = 'Redirecionado';
                    break;
                case 404:
                    $this->msg = 'Página não encontrada';
                    break;
                case 403:
                    $this->msg = 'Acesso negado';
                    break;
                case 401:
                    $this->msg = 'Não autorizado';
                    break;
                case 500:
                    $this->msg = 'Erro de servidor interno';
                    break;
                case 503:
                    $this->msg = 'Serviço não disponível';
                    break; 
                default:
                    $this->msg = '';
            endswitch;
        } else {
            $this->msg = $msg;
        }

        $this->title = env('APP_NAME') . ' - ' . $code;
        $this->code = $code;

        http_response_code($code);
        return template($this)->view('error');
    }
}