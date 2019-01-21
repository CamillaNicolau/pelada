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
                   
                    $ListaPelada = PeladaRepositorio::buscaGeralPelada();
                    foreach($ListaPelada as $pelada) {
                        $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome, 'data_pelada'=>$pelada->data_pelada,'horario'=>$pelada->horario,'rua'=>$pelada->rua,'numero'=>$pelada->numero, 'quadra'=>$pelada->nome_quadra, 'bairro'=>$pelada->bairro,'cidade'=>$pelada->nome_cidade) ;
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
