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
                    
                    $ListaNotificacao = NotificacaoRepositorio::buscarNotificacao(['p.fk_criador='.$_SESSION['id_usuario_logado'].' and p.status <> "encerrada" and data_solicitacao  BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() and visualizada = 0'], true);
                    $html = [];                   
                    
                    foreach($ListaNotificacao as $notificacao) {
                        $data = date("d/m/Y", strtotime($notificacao->data_solicitacao));
                        $html[] =  array("nome"=>$notificacao->nome,"pelada"=>$notificacao->nome_pelada,"data"=>$data,"status"=>$notificacao->status,"id"=>$notificacao->fk_candidato,"visualizada"=>$notificacao->visualizada,"notificacao"=>$notificacao->id_pelada_candidato) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de notificações.")));
                }
            break;
            case'conta_notificacao':
                try{
                    
                    $ContarNotificacao = NotificacaoRepositorio::contarNotificacao(['p.fk_criador='.$_SESSION['id_usuario_logado'].' and p.status <> "encerrada" and pc.visualizada = 0  and pc.data_solicitacao  BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()']);
                    $html = [];
                    foreach($ContarNotificacao as $total) {
                       $html[] =  array("total"=>$total->total);   
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao contar notificações.")));
                }
            break;
            case'visualizacao':
                try{
                    \Doctrine::beginTransaction();
                    $Notificacao = new NotificacaoRepositorio();
                    if($Notificacao->visualizaNotificacao(['id_pelada_candidato='.$_POST['id_notificacao']],$_POST['visualiza'])){
                         \Doctrine::commit();
                        exit(json_encode(array('sucesso'=>true)));
                       
                    } else{
                        \Doctrine::rollBack();
                        exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao inserir a visualizacao na notificação.")));
                    }
                    
                }catch(Erro $E){
                    \Doctrine::rollBack();
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao inserir a visualizacao na notificação.")));
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
