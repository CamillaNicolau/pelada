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
            case 'adicionar':
            try
            {   
                
                \Doctrine::beginTransaction();

                $time = $_POST['time'];
                $posicao =  $_POST['posicao'];
                
                $PeladeiroRepositorio = new PeladaRepositorio();
                $Peladeiro = new Peladeiro();

                $Peladeiro->setTime(new Time($time));
                $Peladeiro->setPosicao(new Posicao($posicao));
                $Localizacao->nomeQuadra = $_POST['nomeQuadra'];
                $Localizacao->rua = $_POST['rua'];           
                $Localizacao->bairro = $_POST['bairro'];
                $Localizacao->numero = $_POST['numero']; 
                $Localizacao->setCidade(new Cidade($cidade));
              
                $LocalizacaoRepositorio->adicionaLocalizacao($Localizacao);
                $id_localizacao = $LocalizacaoRepositorio->adicionaLocalizacao($Localizacao);
                
                $PeladaRepositorio = new PeladaRepositorio();
                $Pelada = new Pelada();

                $Pelada->nome = $_POST['nomePelada'];
                $Pelada->descricao = $_POST['descricaoPelada'];
                $Pelada->duracaoPartida = $_POST['tempoJogo'];
                $Pelada->qtJogadores = $_POST['qtJogadores'];
                $Pelada->sorteio = $_POST['sorteio'];
                $Pelada->localizacao = (int)$id_localizacao;
                $Pelada->dataPartida = $_POST['dataPartida'];
                $Pelada->horario = $_POST['horario'];
                $Pelada->setUsuario(new Usuario($_SESSION['id_usuario_logado']));
                
                $PeladaRepositorio->adicionaPelada($Pelada);
                \Doctrine::commit();
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
               
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar pelada')));
            }
            break;
            case 'buscar_dados_para_edicao':
                try{
                    $Pelada = new Pelada($_POST['id_pelada']);
                    $Localizacao = new Localizacao($Pelada->localizacao);
                    $Cidade = new Cidade($Localizacao->cidade);
                    $saida = array();

                    $saida['idPelada'] = $Pelada->idPelada;
                    $saida['nome'] = $Pelada->nome;
                    $saida['descricao'] = $Pelada->descricao;
                    $saida['duracaoPartida'] = $Pelada->duracaoPartida;
                    $saida['qtJogadores'] = $Pelada->qtJogadores;
                    $saida['sorteio'] = $Pelada->sorteio;
                    $saida['dataPartida'] = $Pelada->dataPartida ? Tratamentos::converteData($Pelada->dataPartida) : null;
                    $saida['horario'] = $Pelada->horario;
                    $saida['nomeQuadra'] = $Localizacao->nomeQuadra;
                    $saida['rua'] = $Localizacao->rua;
                    $saida['bairro'] = $Localizacao->bairro;
                    $saida['numero'] = $Localizacao->numero;
                    $saida['estado'] = $Cidade->estado;
                    $saida['cidade'] = $Localizacao->cidade;
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
                    $cidade = $_POST['cidade'];
                
                    $LocalizacaoRepositorio = new LocalizacaoRepositorio();
                    $Localizacao = new Localizacao();

                    $Localizacao->nomeQuadra = $_POST['nomeQuadra'];
                    $Localizacao->rua = $_POST['rua'];           
                    $Localizacao->bairro = $_POST['bairro'];
                    $Localizacao->numero = $_POST['numero']; 
                    $Localizacao->setCidade(new Cidade($cidade));

                    $LocalizacaoRepositorio->atualizarLocalizacao($Localizacao);

                    $PeladaRepositorio = new PeladaRepositorio();
                    $Pelada = new Pelada();

                    $Pelada->nome = $_POST['nomePelada'];
                    $Pelada->descricao = $_POST['descricaoPelada'];
                    $Pelada->duracaoPartida = $_POST['tempoJogo'];
                    $Pelada->qtJogadores = $_POST['qtJogadores'];
                    $Pelada->sorteio = $_POST['sorteio'];
                    $Pelada->dataPartida = $_POST['dataPartida'];
                    $Pelada->horario = $_POST['horario'];
                    $Pelada->setUsuario(new Usuario($_SESSION['id_usuario_logado']));
         
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
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Pelada removida com sucessos')));
                    
                } catch(Erro $E){
                    \Doctrine::rollBack();
                   exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao remover pelada')));
                }
            break;
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
