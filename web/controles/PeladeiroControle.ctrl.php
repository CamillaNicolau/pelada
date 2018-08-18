<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class PeladeiroControle extends ControlaModelos
{

    public function tratarAcoes()
    {
      
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        { 
            case 'lista_peladeiro':
                try{
                    exit(json_encode(array('sucesso'=>true)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o Shape.")));
                }
            break;
            case 'lista_time':
                try{
                    $html = [];
                    $ListaTime = TimeRepositorio::buscarTime();
                    foreach($ListaTime as $time) {
                      $html[] = array('id'=>$time->id_time_futebol, 'nome'=>$time->nome);
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false)));
                }
            break;
            case 'lista_posicao':
                try{
                    $htmlPosicao = [];
                    $ListaPosicao = PosicaoRepositorio::buscarPosicao();
                    foreach($ListaPosicao as $posicao){
                       $htmlPosicao[] = array('id'=>$posicao->id_posicao_peladeiro, 'nome'=>$posicao->nome) ;
                    }
                    exit(json_encode(['sucesso'=>true, 'html'=>$htmlPosicao]));
                } catch (Erro $E) {
                    exit(json_encode(['sucesso'=>false]));
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
             * Carrega o modelo da página
             */
            $Modelo = $this->carregarModelo('PeladeiroModelo');
          
            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/peladeiro.php';

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
