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
    /**
     * Cabeçalho do e-mail que relaciona diversas mensagens sobre o conteúdo enviado.
     *
     * @var string
     */
    private $headers;

    /**
     * Corpo do pacote enviado no email, que contém a mensagem e o anexo.
     *
     * @var string
     */
    private $body;

    /**
     * Delimitação do cabeçaho do e-mail.
     *
     * @var string
     */
    private $boundary;
      /**
     * Ativa ou desativa a interpretação do conteúdo da mensagem como HTML.
     *
     * @var bool
     */
    private $ativar_html = true;
        
    
    public function __construct($email_destinatario, $assunto, $mensagem)
    {
        $this->mensagem             = $mensagem;
        $this->email_destinatario   = $email_destinatario;
        $this->assunto              = $assunto;
        $this->boundary             = "XYZ-" . date("dmYis") . "-ZYX";
    }
    
    public function __set($atributo, $valor)
    {
        switch($atributo)
        {
            case "destinatario":
                if($valor)
                    $this->destinatario = $valor;
                else
                    echo("Nome do destinatário não deve ser vazio");
            break;
            case "email_destinatario":
                if($valor)
                    $this->email_destinatario = $valor;
                else
                    echo("Para endereços de e-mail informe um valor válido");
            break;
            case "remetente":
                if($valor)
                    $this->remetente = $valor;
                else
                    echo("Valor inválido");
            break;
            case "email_remetente":
                if($valor)
                {
                    $this->email_remetente = $valor;
                }
                else
                    echo("Valor inválido");
            break;
            
            case "ativar_html":
                if($valor)
                    $this->ativar_html = $valor;
                else
                    echo("Valor inválido");
            break;
            
            case "assunto":
                if($valor)
                    $this->assunto = $valor;
                else
                    echo("Valor inválido");
            break;
            case "mensagem":
                if($valor)
                    $this->mensagem = $valor;
                else
                    echo("Valor inválido");
            break;
        
            default:
                echo("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
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
                case 'ativar_html':
            case 'mensagem':
                return $this->$atributo;
            break;
            default:
                echo("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
   private function validaSMTP()
    {
        if(SMTP_ATIVAR)
            return defined('SMTP_EMAIL') && defined('SMTP_SENHA') && defined('SMTP_HOST') && defined('SMTP_AUTH') && defined('SMTP_SECURE');
        else
            return false;
    }

     /**
     * Envia a mensagem para o destinatário.
     *
     * @return bool Retorna true caso a mensagem seja enviada com sucesso.
     */
    public function enviar()
    {   
        if($this->validaSMTP()) { 
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
        } else{

            $mensagem = $this->mensagem;
            $this->body = "--$this->boundary\n";
            /*
             * Esta codificação é designada para que dados binários durem no transporte sobre camadas de transorte
             * que não são 8-bit clean (http://www.php.net/manual/pt_BR/function.base64-encode.php)
             * Isso foi necessário para resolver um bug (http://bugs.php.net/bug.php?id=13044) que estava colocando um
             * ponto de exclamação no meio das mensagens.
             */
            $this->body .= "Content-transfer-encoding:base64\n";
            $this->body .= "Content-Type: " . (($this->ativar_html) ? "text/html" : "text/plain") . ";charset=UTF-8\n\n";
            /*
             * A função chunk_split quebra a string para evitar linhas gigantescas que quebrem o limite do envio.
             */
            $this->body .= chunk_split(base64_encode($mensagem), 76, "\n");
            $this->body .= "\n--$this->boundary\n";
            $this->headers = "MIME-Version: 1.0\n";
            $this->headers .= "Date: " . date("D, d M Y H:i:s O", time()) . "\n";
            $this->headers .= "Content-type: multipart/mixed; charset=UTF-8; boundary=\"$this->boundary\"; \n";
           
           // $this->headers .= $this->getCabecalhoInfoEnvio();
            $this->headers .= "From: \"" . self::getTextoCodificadoCabecalho(($this->remetente) ? $this->remetente : SIS_NOME) . " \" <" . (($this->email_remetente) ? $this->email_remetente : SIS_EMAIL) . ">\n";
            var_dump($this->email_destinatario,self::getTextoCodificadoCabecalho($this->assunto), $this->body);
            return mail($this->email_destinatario, self::getTextoCodificadoCabecalho($this->assunto), $this->body, $this->headers);
        
        }
    }
    /**
     * Gera uma linha do cabeçalho para armazenar informações sobre qual plataforma Vector está enviando esse e-mail.
     * Esta informação fica ofuscada, mas pode ser lida se alguém fizer um pouco de esforço para descobrir seu formato,
     * pois não está tão obscuro assim.
     * O objetivo desse cabeçalho é facilitar a identificação da origem de mensagens enviadas acidentalmente ou de e-mails
     * de retorno.
     * Esta informação poderá ser utilizada pela classe Mailing para averiguar se o e-mail destinatário está em listas
     * negras de envio por já ter dado erro de retorno.
     *
     * @return string Linha para ser colocada no cabecalho do e-mail para armazenar informações sobre o ponto de origem do envio.
     */
    private function getCabecalhoInfoEnvio()
    {
        $dados_envio = base64_encode(json_encode(array('cliente' => CLIENTE_NOME, 'url_raiz' => URL_RAIZ_SITE, 'script' => $_SERVER['PHP_SELF'], 'email_destinatario' => $this->email_destinatario)));
        $tamanho_string = strlen($dados_envio);
        $dados_envio_ofuscado = substr($dados_envio, floor($tamanho_string / 2)) . substr($dados_envio, 0, floor($tamanho_string / 2));
        return "X-Mailer: " . SIS_NOME . "/" . trim(chunk_split($dados_envio_ofuscado, 76, "\n\t")) . "\n";
    }
          /**
     * Método utilizado pela classe para converter valores de texto utilizados nos cabeçalhos e que possuem caracteres especiais como acentos,
     * cedilhas, etc. É preciso utilizar esse artifícil no assunto e nos nomes de remetentes, etc.. para que não dê problemas de caracteres visto
     * que o protocolo de e-mail utiliza a tabela ASCII simples.
     *  
     * @see http://datatracker.ietf.org/doc/rfc1342/
     * @param string $texto Texto que será convertido já com o padrão utilizado em cabeçalhos de e-mail
     * @return string String formatada para ser utilizada como valor de parâmetro em cabeçalhos de e-mail.
     */
    private static function getTextoCodificadoCabecalho($texto)
    {
        /*
         * Codifica o cabeçalho em base 64 para evitar problemas com codificação de caracteress
         */
        return "=?UTF-8?B?".base64_encode($texto)."?=";
    }
       
    
}