<?php


/**
 * O objeto imagem é utilizado pelo sistema para manipulação da imagem. A classe propõe que qualquer sistema que utilize imagem não acesse o 
 * arquivo da imagem diretamente, utilizando para isso esta classe.
 * 
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Imagem
{

    /**
     * Resource do arquivo imagem para manipulação.
     *
     * @var image_resource
     */
  
    private $imagem;
    /**
     * Largura da imagem em pixels.
     *
     * @var int
     */
    private $largura;

    /**
     * Altura da imagem em pixels.
     *
     * @var int
     */
    private $altura;

    /**
     * Tipo da imagem baseado no método 'getimagesize' e 'image_type_to_extension'.
     *
     * @var int
     */
    private $tipo;
  
    /**
     * Extensão fornecida pela função 'image_type_to_extension' para a imagem instanciada. Ex.: '.jpg'
     * Pode não ser a mesma extensão do arquivo.
     *
     * @var string
     */
    private $extensao;
  
    /**
     * Armazena o nome do tipo do conteúdo (Content-type).
     *
     * @var string
     */
    private $mime_type;
  
    /**
     * Informa se a imagem da instância foi alterada desde a sua construção e ainda não foi salva, pois se ela for descartada a imagem
     * original não será afetada, e caso ela seja enviada para o navegador é necessário se basear na instância e não no arquivo original (cuja leitura é mais rápida).
     *
     * @var bool
     */
    private $alterada = false;
      
    /**
     * Valor constante de identificação do tipo de imagem .gif.
     */
    const TP_GIF = 1;
  
    /**
     * Valor constante de identificação do tipo de imagem .jpeg.
     */
    const TP_JPEG = 2;
  
    /**
     * Valor constante de identificação do tipo de imagem .png.
     */
    const TP_PNG = 3;
  
    /**
     * Valor constante de string com os valores de identificação dos tipos aceitos pela classe para manipulação.
     */
    const tipos_aceitos = "1,2,3";
  
    /**
     * Cria uma imagem baseado no arquivo informado no parâmetro. Caso o arquivo não seja uma imagem ou não
     * seja uma imagem de tipo aceito a classe disparará uma exceção para interromper a tentativa de utilizar um
     * arquivo estranho.
     * Altera a extensão do arquivo caso seja necessário para sua manipulação.
     *
     * @param string $path Endereço do arquivo de imagem que será utilizado.
     * @return void
     */
    public function __construct($path)
    {
        $this->path_fonte = $path;
        $dados = getimagesize($path);
        list($this->largura, $this->altura, $this->tipo) = $dados;
        $this->mime_type = $dados['mime'];
        if(!in_array($this->tipo, explode(",", self::tipos_aceitos)))
            throw new Excecao("Tipo de imagem não aceito pela classe Imagem (" . $this->tipo . ")");
        switch($this->tipo)
        {
            case self::TP_GIF:
                $this->imagem = imagecreatefromgif($path);
            break;
            case self::TP_JPEG:
                $this->imagem = imagecreatefromjpeg($path);
            break;
            case self::TP_PNG:
                $this->imagem = imagecreatefrompng($path);
                imagesavealpha($this->imagem, true);
            break;
        }
        $this->extensao = image_type_to_extension($this->tipo);
    }
    
    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Valor do atributo no seu tipo original.
     */
    public function __get($atributo)
    {
        switch($atributo)
        {
            case "extensao":
            case "largura":
            case "altura":
            case 'mime_type':
                return $this->$atributo;
            break;
            default:
                throw new Excecao("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
  
    /**
     * Retorna uma lista de extensões aceitas para manipulação de imagens por essa classe.
     * Esta lista é estática, pois depende dos métodos implementados para manipular o arquivo de imagem.
     *
     * @return array Retorna a lista de extensões aceitas.
     */
    public static function getExtensoesAceitas()
    {
        return array("gif", "jpg", "jpeg", "png");
    }
    /**
     * Informa se o arquivo de imagem é de um tipo aceito pela classe.
     *
     * @param string $path_imagem Endereço do arquivo de imagem que será verificado.
     * @return int|bool Retona índice que representa o tipo da imagem ou false caso não seja de um tipo aceito.
     * @see http://php.net/manual/pt_BR/function.getimagesize.php
     */
    public static function aceitaImagem($path_imagem)
    {
        list($largura, $altura, $tipo) = getimagesize($path_imagem);
        if(in_array($tipo, explode(",", self::tipos_aceitos))) {
            return $tipo;
        } else {
            return false;
        }
    }
     /**
     * Redimensiona a imagem mantendo ou não a proporção, alterando sua altura ou largura baseado no parâmetros informados.
     *
     * @param bool $manter_proporcao Indica se a alteração nas dimensões devem respeitar a proporção da imagem.
     * @param int $largura_max Largura máxima que deve ter a imagem após a alteração nas suas dimensões.
     * @param int $altura_max Altura máxima que deve ter a imagem após a alteração nas suas dimensões. Caso não seja informada, o redimensionamento levará em conta apenas a largura.
     * @return bool Retorna true caso a imagem seja redimensionada com sucesso.
     */
    public function redimensionar($manter_proporcao, $largura_max, $altura_max = false)
    {
        if(!$largura_max)
            echo("O valor da largura máxima da imagem não pode ser igual a zero");
        $dif_largura = $largura_max / $this->largura;
        if($altura_max) {
            $dif_altura = $altura_max / $this->altura;
        } else {
           $dif_altura = 0;
        }
        if($manter_proporcao)
        {
            $proporcao = min($dif_largura, $dif_altura);
            $nova_largura = $this->largura * $proporcao;
            $nova_altura = $this->altura * $proporcao;
        }else
        {
            $nova_largura = $largura_max;
            $nova_altura = ($altura_max) ? $altura_max : $this->altura;
        }
        $nova_imagem = imagecreatetruecolor($nova_largura, $nova_altura);
        $sucesso = imagecopyresampled($nova_imagem, $this->imagem, 0, 0, 0, 0, $nova_largura, $nova_altura, $this->largura, $this->altura);
        if($sucesso)
        {
            imagedestroy($this->imagem);
            $this->imagem = $nova_imagem;
            $this->largura = $nova_largura;
            $this->altura = $nova_altura;
            $this->alterada = true;
            return true;
        }else {
            return false;
        }
    }
    /**
     * Salva o arquivo de imagem em disco, utilizando um outro nome ou sobre-escrevendo o arquivo original.
     *
     * @param string $file_name Endereço completo com o nome do novo arquivo a ser salvo. A classe não concatena a extensão do arquivo automaticamente, utilize o atributo extensao.
     * @return bool True caso a imagem tenha sido escrita em disco com sucesso.
     */
    public function salvar($file_name = false)
    {
        if(!$file_name)
        {
            $this->alterada = false;
            $file_name = $this->path_fonte;
        }
        switch($this->tipo)
        {
            case self::TP_GIF:
                if(imagegif($this->imagem, $file_name)){
                    return true;
                } else {
                    echo("Erro ao salvar imagem gif na classe Imagem do sistema");
                }
            break;
            case self::TP_JPEG:
                if(imagejpeg($this->imagem, $file_name, 90)) {
                    return true;
                } else {
                    echo("Erro ao salvar imagem jpeg na classe Imagem do sistema");
                }
            break;
            case self::TP_PNG:
                if(imagepng($this->imagem, $file_name)) {
                    return true;
                } else {
                    echo("Erro ao salvar imagem png na classe Imagem do sistema");
                }
            break;
        }
    }
}