<?php

/**
 * Classe responsável em receber os dados do array contendo os corringas e valores, aplicar em
 * um template pre formatado com o html e css e aplicar em uma forma válida de e-mail. 
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */

class TemplateEmail
{
    
    /**
     * Array com os valores a ser substituidos no template.
     *
     * @var array 
     */
    private $valores_tpl = array();
    
    /**
     * Nome do template que também identifica se é plataforma ou plugs.
     *
     * @var string 
     */
    private $nome_template;
    
    /**
     * Caminho do HTML do template.
     *
     * @var string 
     */
    private $caminho_html;
    
    /**
     * Caminho do CSS para incorporar no template.
     *
     * @var string 
     */
    private $caminho_css;
   
    /**
     * Constantes
     */
    const CAMINHO_PADRAO_TEMPLATES_HTML = "assets/email/";
    const CAMINHO_PADRAO_TEMPLATES_CSS = "assets/css/email/";
    const CAMINHO_TEMPLATES_PERSONALIZADO_HTML = "email/html/";
    const CAMINHO_TEMPLATES_PERSONALIZADO_CSS = "email/css/";
    
    /**
     * Método responsável em receber os dados em array contendo os coringas e valores e o nome do template
     * a ser utilizado e fazer as validações referente ao nome do plug e caminho dos templates.
     * 
     * @param array $dados_email Array com os dados a ser substituido no template.
     * @param string $nome_template Nome do arquivo de template a ser utilizado
     * @return void
     */
    public function __construct($valores_tpl = array(), $nome_template)
    {
        $this->valores_tpl = $valores_tpl;
        $this->nome_template = $nome_template;
        
        $this->setCaminhoTemplates();
    }
    
    /**
     * Método responsável em setar o caminho do templates.
     * 
     * @return void
     */
    private function setCaminhoTemplates()
    {
        $this->caminho_html = PATH_ARQUIVOS . self::CAMINHO_TEMPLATES_PERSONALIZADO_HTML . $this->nome_template . ".html";
        $this->caminho_css = PATH_ARQUIVOS . self::CAMINHO_TEMPLATES_PERSONALIZADO_CSS . $this->nome_template . ".css";

        if(!file_exists($this->caminho_html) && !file_exists($this->caminho_css))
        {
            $this->caminho_html = PATH_RAIZ . self::CAMINHO_PADRAO_TEMPLATES_HTML . $this->nome_template . ".html";
            $this->caminho_css = PATH_RAIZ . self::CAMINHO_PADRAO_TEMPLATES_CSS . $this->nome_template . ".css";

            if(!file_exists($this->caminho_html) && !file_exists($this->caminho_css))
            {
                echo("Caminho do templates html e css inválidos.");
            }
        }
    }
    
    /**
     * Responsável em substituir os coringas nos tamplates e converter os estilos inline.
     * 
     * @return string
     */
    public function getHtmlTemplates()
    {
        $conteudo_tpl = file_get_contents($this->caminho_html);
        $conteudo_css = file_get_contents($this->caminho_css);

        foreach($this->valores_tpl as $chave=>$valor)
        {
            $conteudo_tpl = str_replace('[#' . $chave . '#]', '', $conteudo_tpl);
        }

        preg_match_all('/\[#.*?\/#]/s', $conteudo_tpl, $substituir_expressao, PREG_SET_ORDER);

        foreach($substituir_expressao as $valor)
        {
            $conteudo_tpl =  str_replace($valor, '', $conteudo_tpl);
        }

        $conteudo_tpl =  str_replace('[/#]', '', $conteudo_tpl);
        $substitui_dados = str_replace(array_keys($this->valores_tpl), array_values($this->valores_tpl), $conteudo_tpl);

        $emogrifier = new \Pelago\Emogrifier();
        $emogrifier->setHtml($substitui_dados);
        $emogrifier->setCss($conteudo_css);

        return $emogrifier->emogrify();
    }
}
