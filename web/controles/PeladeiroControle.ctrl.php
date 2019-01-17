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
                if(isset($_FILES['imagemUsuario'])) {
                    $msg_erro = false;
                    if ($_FILES['imagemUsuario']['size'] > TAMANHO_IMAGEM) {
                        exit(json_encode(["sucesso" => false,"mensagem" => "Imagem muito grande! O tamanho permitido é de " . UsuarioModelo::verificaTamanhoImagem(TAMANHO_IMAGEM) . "<br />"]));
                    }
           
                    if ($msg_erro) {
                        exit(json_encode(["sucesso" => false, "mensagem" => implode("<br>", $msg_erro)]));
                    }
                }
                \Doctrine::beginTransaction();

                $time = $_POST['time'];
                $posicao =  $_POST['posicao'];
                
                $PeladeiroRepositorio = new PeladeiroRepositorio();
                $Peladeiro = new Peladeiro();

                $imagem = pathinfo($_FILES['imagemUsuario']['name']);
                $nomeImagem = Tratamentos::padraoUrl($imagem['filename']);
                $url = $nomeImagem .'.' . $imagem['extension'];
                
                $Peladeiro->setTime(new Time($time));
                $Peladeiro->setPosicao(new Posicao($posicao));
                $Peladeiro->nome = $_POST['nomePeladeiro'];
                $Peladeiro->email = $_POST['emailPeladeiro'];
                $Peladeiro->telefone = $_POST['telPeladeiro'];
                $Peladeiro->data_nascimento = $_POST['dataNascimento'];
                $Peladeiro->url_imagem = isset($_FILES['imagemUsuario']['name']) ? $url :null;
                $Peladeiro->participacao = $_POST['participacao'];
                $Peladeiro->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                if(!$PeladeiroRepositorio->adicionaPeladeiro($Peladeiro)){
                    exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao inserir imagem')));
                 }
                if(isset($_FILES['imagemUsuario'])){
                    UsuarioModelo::salvaFoto($_FILES['imagemUsuario']);
                }
                \Doctrine::commit();
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
               
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar pelada')));
            }
            break;
            case 'buscar_dados_para_edicao':
                try{
                    $Peladeiro = new Peladeiro($_POST['id_peladeiro']);
                    $Posicao = new Posicao($Peladeiro->posicao);
                    $Time = new Time($Peladeiro->timeFutebol);
                    $saida = array();

                    $saida['idPeladeiro'] = $Peladeiro->idPeladeiro;
                    $saida['nome'] = $Peladeiro->nome;
                    $saida['email'] = $Peladeiro->email;
                    $saida['telefone'] = $Peladeiro->telefone;
                    $saida['data_nascimento'] = $Peladeiro->data_nascimento ? Tratamentos::converteData($Peladeiro->data_nascimento) : null;
                    $saida['posicao'] = $Peladeiro->posicao; 
                    $saida['time'] = $Peladeiro->timeFutebol;
                    $saida['participacao'] = $Peladeiro->participacao;
                    $saida['imagemPeladeiro'] = URL_USUARIO. '/'. UsuarioModelo::PREFIXO_MINIATURA . $Peladeiro->url_imagem;


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
                    $html = [];
                    $ListaPeladeiro = PeladeiroRepositorio::buscarPeladeiro();
                    foreach($ListaPeladeiro as $peladeiro) {
                        $html[] =  array('id'=>$peladeiro->id_peladeiro,'nome'=>$peladeiro->nome, 'email'=>$peladeiro->email) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o peladeiro.")));
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
