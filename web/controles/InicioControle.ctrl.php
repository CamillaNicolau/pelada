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
                        $DataPelada = $pelada->data_pelada;
                        $novaData = date("d/m/Y", strtotime($DataPelada));
                        $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada, 'data_pelada'=>$novaData,'horario'=>$pelada->horario,'rua'=>$pelada->rua,'numero'=>$pelada->numero, 'quadra'=>$pelada->nome_quadra, 'bairro'=>$pelada->bairro,'cidade'=>$pelada->nome_cidade) ;
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
