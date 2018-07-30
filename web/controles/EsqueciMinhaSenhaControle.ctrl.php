<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class EsqueciMinhaSenhaControle extends ControlaModelos
{
    public function tratarAcoes(){
      //Nada a fazer
    }
    public function getHtml()
    {
        try
        {
                /*
             * Carrega o modelo da página
             */
            $Modelo = $this->carregarModelo('EsqueciMinhaSenhaModelo');

            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/cabecalho.php';

            /*
             * Conteúdo
             */
            require PATH_RAIZ . '/visualizacoes/esqueciMinhaSenha.php';

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
