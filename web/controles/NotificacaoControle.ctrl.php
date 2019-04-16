<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class NotificacaoControle extends ControlaModelos
{

    public function tratarAcoes()
    {
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
            case 'lista_notificacao':
                try{
                    
                    $ListaNotificacao = PeladaRepositorio::buscarNotificacao(['p.fk_criador='.$_SESSION['id_usuario_logado']]);
                    $html = [];                   
                    
                    foreach($ListaNotificacao as $notificacao) {
//                        var_dump($notificacao);
                        $data = date("d/m/Y", strtotime($notificacao->data_solicitacao));
                        $html[] =  array("nome"=>$notificacao->nome,"pelada"=>$notificacao->nome_pelada,"data"=>$data,"status"=>$notificacao->status,"id"=>$notificacao->fk_candidato) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de pelada.")));
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
            require PATH_RAIZ . '/visualizacoes/notificacao.php';

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
