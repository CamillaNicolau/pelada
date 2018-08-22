<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class PeladaControle extends ControlaModelos
{

    public function tratarAcoes()
    {
     
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
            case 'adicionar':
            try
            {   
                if($_POST['qtJogadores'] < MIN_JOGADORES){
                  exit(json_encode(array('sucesso'=>false,'mensagem'=>'Quantidade de jogadores invalidos')));
                }
                \Doctrine::beginTransaction();

                $cidade = $_POST['cidade'];
                
                $LocalizacaoRepositorio = new LocalizacaoRepositorio();
                $Localizacao = new Localizacao();
                     
                $Localizacao->rua = $_POST['rua'];
                $Localizacao->bairro = $_POST['bairro'];
                $Localizacao->numero = $_POST['numero'];
                $Localizacao->setCidade(new Cidade($cidade));
                var_dump($LocalizacaoRepositorio->adicionaLocalizacao($Localizacao));
             
                $LocalizacaoRepositorio->adicionaLocalizacao($Localizacao);
                //$id_localizacao = $LocalizacaoRepositorio->adicionaLocalizacao($Localizacao);
               exit();  
                $PeladaRepositorio = new PeladaRepositorio();
                $Pelada = new Pelada();

                $Pelada->nome = $_POST['nomePelada'];
                $Pelada->descricao = $_POST['descricaoPelada'];
                $Pelada->duracaoPartida = $_POST['tempoJogo'];
                $Pelada->qtJogadores = $_POST['qtJogadores'];
                $Pelada->sorteio = $_POST['sorteio'];
                $Pelada->localizacao = $id_localizacao;
                $Pelada->dataPartida = $_POST['dataPartida'];
                $Pelada->fkUsuario = $_SESSION['id_usuario_logado'];

                $PeladaRepositorio->adicionaPelada($Pelada);

                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
                \Doctrine::commit();
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar pelada')));
            }
            break;
            case 'buscar_dados_para_edicao':
                try{
                    $Pelada = new Pelada($_POST['id_pelada']);
                    $saida = array();

                    $saida['idPelada'] = $Pelada->idPelada;
                    $saida['nome'] = $Pelada->nome;
                    $saida['descricao'] = $Pelada->descricao;
                    $saida['duracaoPartida'] = $Pelada->duracaoPartida;
                    $saida['qtJogadores'] = $Pelada->qtJogadores;
                    $saida['sorteio'] = $Pelada->sorteio;
                    $saida['dataPartida'] = $Pelada->dataPartida ? Tratamentos::converteData($Pelada->dataPartida) : null;

                    exit(json_encode($saida));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false)));
                }
            break;
            case 'atualizar':
                try{
                    if($_POST['qtJogadores'] < MIN_JOGADORES){
                      exit(json_encode(array('sucesso'=>false,'mensagem'=>'Quantidade de jogadores invalidos')));
                    }
                    \Doctrine::beginTransaction();
                    $PeladaRepositorio = new PeladaRepositorio();
                    $Pelada = new Pelada($_POST['id_pelada']);

                    $Pelada->nome = $_POST['nomePelada'];
                    $Pelada->descricao = $_POST['descricaoPelada'];
                    $Pelada->duracaoPartida = $_POST['tempoJogo'];
                    $Pelada->qtJogadores = $_POST['qtJogadores'];
                    $Pelada->sorteio = $_POST['sorteio'];
                    $Pelada->dataPartida = $_POST['dataPartida'];

                    $PeladaRepositorio->atualizarPelada($Pelada);
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
                    \Doctrine::commit();
                } catch (Erro $E) {
                \Doctrine::rollBack();
                 exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao atualizar dados da pelada')));
                }
            break;
            case 'remover_pelada':
                try{
                    \Doctrine::beginTransaction();
                    $PeladaRepositorio = new PeladaRepositorio();
                    $Pelada = new Pelada($_POST['id_pelada']);
                    $PeladaRepositorio->deletarPelada($Pelada);

                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Pelada removida com sucessos')));
                    \Doctrine::commit();
                } catch(Erro $E){
                    \Doctrine::rollBack();
                   exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao remover pelada')));
                }
            break;
            case 'lista_pelada':
                try{

                    $html = [];
                    $ListaPelada = PeladaRepositorio::buscarPelada();

                    foreach($ListaPelada as $pelada) {
                        $html[] =  array('id'=>$pelada->idPelada,'nome'=>$pelada->nome) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o Shape.")));
                }
            break;
            case 'lista_estado':
                try{
                    $html = [];
                    $ListaEstado = EstadoRepositorio::buscarEstado();
                    foreach($ListaEstado as $estado) {
                      $html[] = array('id'=>$estado->id_estado, 'nome'=>$estado->nome, 'sigla'=>$estado->sigla);
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false)));
                }
            break;
            case 'lista_cidade':
                try{

                    $estado = $_POST['id_estado'];
                    $htmlCidade = [];
                    $ListaCidade = CidadeRepositorio::buscarCidade($estado);
                 
                    foreach($ListaCidade as $cidade){
                         
                       $htmlCidade[] = array('id'=>$cidade->id_cidade, 'nome'=>$cidade->nome, 'estado'=>$cidade->fk_estado) ;
                         
                    }
                    exit(json_encode(['sucesso'=>true, 'html'=>$htmlCidade]));
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
            $Modelo = $this->carregarModelo('PeladaModelo');
          
            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/pelada.php';

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
