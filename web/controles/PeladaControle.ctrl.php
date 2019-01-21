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
            case 'lista_pelada':
                try{

                    $html = [];
                    $ListaPelada = PeladaRepositorio::buscarPelada();
                    foreach($ListaPelada as $pelada) {
                        $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada, 'data_partida'=>Tratamentos::converteData($pelada->data_pelada), 'horario'=>$pelada->horario) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de pelada.")));
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

                    $estado = (int)$_POST['id_estado'];
                    $htmlCidade = [];
                    $ListaCidade = CidadeRepositorio::buscarCidade(null,null,$estado);
                    foreach($ListaCidade as $cidade){
                       $htmlCidade[] = array('id'=>$cidade->id_cidade, 'nome'=>$cidade->nome_cidade, 'estado'=>$cidade->fk_estado) ;
                         
                    }
                    exit(json_encode(['sucesso'=>true, 'html'=>$htmlCidade]));
                } catch (Erro $E) {
                    exit(json_encode(['sucesso'=>false]));
                }
            break;
            case 'buscar_pelada':
                try{
                    
                    $html = [];
                    $EncontrarPelada= PeladaRepositorio::buscaGeralPelada(['nome_cidade LIKE "%'.$_POST['cidade'].'%"']);
                    if(count($EncontrarPelada) > 0){
                        foreach($EncontrarPelada as $pelada) {
                            $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada,'rua'=>$pelada->rua,'numero'=>$pelada->numero, 'quadra'=>$pelada->nome_quadra, 'bairro'=>$pelada->bairro,'cidade'=>$pelada->nome_cidade, 'sigla'=>$pelada->sigla, 'telefone_usuario'=>$pelada->telefone,'email_usuario'=>$pelada->email) ;
                        }
                        exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                    } else{
                        exit(json_encode(['sucesso'=>false, "mensagem" => "Não foi encontrado nenhuma pelada."]));
                    }
                }catch(Erro $E){
                    exit(json_encode(['sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o pelada."]));
                }
            break;
            case 'buscar_peladeiro':
                try{
                    $html = [];
                    $ListaPeladeiro = PeladeiroRepositorio::buscarPeladeiro();
                    foreach($ListaPeladeiro as $peladeiro) {
                        $html[] =  array('id'=>$peladeiro->id_usuario,'nome'=>$peladeiro->nome) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o peladeiro.")));
                }
            break;
            case 'adicionar_peladeiro':
            try
            {
               
                // \Doctrine::beginTransaction();
var_dump($_REQUEST);
           
                // \Doctrine::commit();
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
               
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar pelada')));
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
