<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class InicioControle extends ControlaModelos
{

    public function tratarAcoes()
    {
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
            case 'lista_pelada':
                try{

                    $html = [];
                   
                    $ListaPelada = PeladaRepositorio::buscaGeralPelada(['p.fk_peladeiro ='.$_SESSION['id_usuario_logado']]);
                    foreach($ListaPelada as $pelada) {
                        $novaData = date("d/m/Y", strtotime($pelada->data_pelada));
                        $horarioNovo = date("H:i", strtotime($pelada->horario));
                        $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada, 'data_pelada'=>$novaData,
                            'horario'=>$horarioNovo,'rua'=>$pelada->rua,'numero'=>$pelada->numero,
                            'quadra'=>$pelada->nome_quadra, 'bairro'=>$pelada->bairro,'cidade'=>$pelada->nome_cidade,
                            'id_peladeiro_pelada'=>$pelada->id, 'data_atual'=>date("d/m/Y"), 'confirmacao'=>$pelada->confirmacao) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de pelada.")));
                }
            break;
             case 'status_pelada_peladeiro':
                try{
                    \Doctrine::beginTransaction();
                    $confimarPeladeiro = new PeladaRepositorio();
                    if($_POST['confirmacao'] == "1"){
                        if(!$confimarPeladeiro->statusPeladeiroPelada(['id='.$_POST['id_pelada_peladeiro']])){
                            exit(json_encode(array('sucesso'=>false,'mensagem'=>"Erro ao confirmar a presença")));
                        } else{
                            \Doctrine::commit();
                            exit(json_encode(array('sucesso'=>true,'mensagem'=>"Presença confirmada")));
                        }
                    } else{
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>"Pelada descartada")));
                    }   
                }catch(Erro $E){
                    \Doctrine::rollBack();
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
            require PATH_RAIZ . '/visualizacoes/inicio.php';

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
