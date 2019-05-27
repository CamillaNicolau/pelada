<?php

/**
 * Gerencia a exibição da página não encontrada.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class PaginaNaoEncontradaControle
{

    public function tratarAcoes()
    {
      //Nada a fazer
    }
    public function getHtml()
    {
        try
        {
            header("HTTP/1.0 404 Not Found");
            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/cabecalho.php';
            /*
             * Conteúdo da Página não encontrada
             */
            require PATH_RAIZ . '/visualizacoes/PaginaNaoEncontrada.php';
            /*
             * Rodapé
             */
            require PATH_RAIZ . '/visualizacoes/incluir/rodape.php';
        }
        catch (Exception $ex)
        {
            echo 'Exceção: ',  $ex->getMessage(), "\n";
        }
		
    }

}
