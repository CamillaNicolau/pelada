<?php

/**
 * Classe responsável pelo envio de mensagens por e-mail. Centraliza o sistema de envio de
 * e-mails para facilitar a configuração e manipulação de comunicação do sistema.
 *
 * @author Camilla Nicolau
 */

class Email
{
    private $destinatario;
    private $email_destinatario;
    private $remetente;
    private $email_remetente;
    private $assunto;
    private $mensagem;
    
    const EMAIL_NOREPLY = 'nao-responda@maispelada.com.br';
    
    
    public function __construct($email_destinatario, $assunto, $mensagem)
    {
        $this->mensagem             = $mensagem;
        $this->email_destinatario   = $email_destinatario;
        $this->assunto              = $assunto;
    }
    
    public function __set($atributo, $valor)
    {
        switch($atributo)
        {
            case "destinatario":
                if($valor)
                    $this->destinatario = $valor;
                else
                    throw new Excecao("Nome do destinatário não deve ser vazio");
            break;
            case "email_destinatario":
                if($valor)
                    $this->email_destinatario = $valor;
                else
                    throw new Excecao("Para endereços de e-mail informe um valor válido");
            break;
            case "remetente":
                if($valor)
                    $this->remetente = $valor;
                else
                    throw new Excecao("Valor inválido");
            break;
            case "email_remetente":
                if($valor)
                {
                    $this->email_remetente = $valor;
                }
                else
                    throw new Excecao("Valor inválido");
            break;
            
            case "assunto":
                if($valor)
                    $this->assunto = $valor;
                else
                    throw new Excecao("Valor inválido");
            break;
            case "mensagem":
                if($valor)
                    $this->mensagem = $valor;
                else
                    throw new Excecao("Valor inválido");
            break;
        
            default:
                throw new Excecao("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Retorna dado do atributo informado.
     */
    public function __get($atributo)
    {
        switch($atributo)
        {
            case 'destinatario':
            case 'email_destinatario':
            case 'remetente':
            case 'email_remetente':
            case 'assunto':
            case 'mensagem':
                return $this->$atributo;
            break;
            default:
                throw new Excecao("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
   
     /**
     * Envia a mensagem para o destinatário.
     *
     * @return bool Retorna true caso a mensagem seja enviada com sucesso.
     */
    public function enviar()
    {   
        
        $email = new PHPMailer\PHPMailer\PHPMailer();

        $email->CharSet = 'UTF-8';
        $email->isSMTP();
        $email->Host = SMTP_HOST;
        $email->SMTPAuth = SMTP_AUTH;
        $email->Username = SMTP_EMAIL;
        $email->Password = SMTP_SENHA;
        $email->SMTPSecure = SMTP_SECURE;
        $email->Port = SMTP_PORTA;

        defined('SMTP_NOME') ? $email->setFrom(SMTP_EMAIL, SMTP_NOME) : $email->setFrom(SMTP_EMAIL, (isset($this->remetente) ? $this->remetente : SIS_NOME));
        $email->addAddress($this->email_destinatario);

        $email->isHTML(true);
        $email->Subject = $this->assunto;
        $email->Body    = $this->mensagem;
     
        return $email->send();
    }
}