<?php

/**
 * Gerencia a exibição da página não encontrada.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class PaginaNaoEncontradaControle
{

    public function tratarAcoes()
    {
      
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
