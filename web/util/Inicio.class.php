<?php

/**
 * Gerencia o controle e exibição da visualização.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Inicio
{
    /**
     * Recebe o controle da index monta o html inicial.
     */
    private static $pagina_atual;
  
    public function __construct($valorGet)
    {
      self::$pagina_atual = strtolower($valorGet);
        if (!file_exists(PATH_RAIZ . '/controles/'.$valorGet.'Controle.ctrl.php')){
            $valorGet = 'PaginaNaoEncontrada';
        }
        require_once PATH_RAIZ . '/controles/'.$valorGet.'Controle.ctrl.php';
			
        $montaNomeControle = $valorGet.'Controle';
        $MontaIndex = new $montaNomeControle();
        $MontaIndex->tratarAcoes();
        $MontaIndex->getHtml();
    }
  
    public static function getNomePaginaAtual()
    {
        return self::$pagina_atual;
    }
}