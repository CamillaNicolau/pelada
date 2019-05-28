<?php

/**
 * Gerencia a exibição da página de relatorio.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class RelatorioControle
{

    public function tratarAcoes()
    {
      if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
          case 'lista_relatorio':
            try{
                 if($_POST['tipo_relatorio'] == '1'){
                        $condicao = 'pe.fk_criador='.$_SESSION['id_usuario_logado']. ' and p.confirmacao=1';
                        $ListaRelatorio = PeladaRepositorio::buscaGeralPelada([$condicao]);
                    } else if($_POST['tipo_relatorio'] == '2'){
                        $mes_atual = date("m");
                        $condicao = 'p.fk_criador ='.$_SESSION['id_usuario_logado'].' and MONTH(p.data_pelada) = '.$mes_atual;
                        $ListaRelatorio = PeladaRepositorio::buscarPelada([$condicao]);
                    } else {
                        $condicao = 'pe.fk_criador='.$_SESSION['id_usuario_logado']. ' and p.confirmacao=2';
                        $ListaRelatorio = PeladaRepositorio::buscaGeralPelada([$condicao]);
                    } 
                $html = [];
                foreach ($ListaRelatorio as $pelada){
                    $data = date("d/m/Y", strtotime($pelada->data_pelada));
                    $html[] =  array('tipo_relatorio'=>$_POST['tipo_relatorio'],'pelada'=>$pelada->nome_pelada, 'peladeiro'=>$pelada->nome,
                        'data_pelada'=>$data) ;   
                }
                exit(json_encode(array('sucesso'=>true,'html'=>$html)));
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
