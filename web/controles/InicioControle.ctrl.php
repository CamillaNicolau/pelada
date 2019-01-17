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
    public function tratarAcoes(){
      
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao']){
            case "lista_pelada":
                try {
                    $id = $_SESSION['id_usuario_logado'];
               
                    $ListaPelada = PeladaRepositorio::buscarPelada(array('id_pelada'=>$id));
                    $contador = count($ListaPelada);
                        
                    $html = [];
                    for($i = 0; $i < $contador; $i++){

                        $id_pelada = $ListaPelada[$i]->id_pelada;
                        $nome_pelada = $ListaPelada[$i]->nome;
                        $data_pelada = date('d-m-Y', strtotime($ListaPelada[$i]->data_pelada));
                        $horario = date('H:i', strtotime($ListaPelada[$i]->horario));
                        $observacoes = $ListaPelada[$i]->descricao;
                        $localizacao = $ListaPelada[$i]->fk_localizacao;
                       
                        $ListaLocalizacao = LocalizacaoRepositorio::buscarLocalizacao(array('fk_localizacao'=>$localizacao));

                        $nome_quadra = $ListaLocalizacao[$i]->nome_quadra;
                        $rua = $ListaLocalizacao[$i]->rua;
                        $bairro = $ListaLocalizacao[$i]->bairro;
                        $numero = $ListaLocalizacao[$i]->numero;
                        $cidade = $ListaLocalizacao[$i]->fk_cidade;
                        
                        $Cidade = CidadeRepositorio::buscarCidade($cidade);
                        
                        $nome_cidade = $Cidade[$i]->nome;
                        
             
                        $html[] =  array('nome_pelada'=>$nome_pelada,'data_pelada'=>$data_pelada,'observacoes'=>$observacoes,
                        'horario'=>$horario,'nome_quadra'=>$nome_quadra,'rua'=>$rua,
                        'bairro'=>$bairro,'numero'=>$numero, 'cidade'=>$nome_cidade,'id'=>$id_pelada) ;
                    }
                    
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
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
             * Conteúdo
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
