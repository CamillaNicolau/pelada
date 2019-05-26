<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class RelatorioControle extends ControlaModelos
{

    public function tratarAcoes()
    {
      if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
          case 'busca_pelada':
            try{
              
              $Pelada = PeladaRepositorio::buscarPelada();
              exit(json_encode($retorno));
            } catch (Erro $E){
              
            }
            break;
        }  
    }
    public function getHtml()
    {
        try
        {
            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/menu.php';

            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/relatorio.php';

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
