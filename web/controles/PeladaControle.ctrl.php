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
                    $saida['localizacao'] = $Pelada->localizacao;
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
                    $Localizacao = new Localizacao($_POST['id_localizacao']);

                    $Localizacao->nomeQuadra = $_POST['nomeQuadra'];
                    $Localizacao->rua = $_POST['rua'];           
                    $Localizacao->bairro = $_POST['bairro'];
                    $Localizacao->numero = $_POST['numero']; 
                    $Localizacao->setCidade(new Cidade($cidade));
                
                    $LocalizacaoRepositorio->atualizarLocalizacao($Localizacao);
                    \Doctrine::commit();
                    \Doctrine::beginTransaction();
                    $PeladaRepositorio = new PeladaRepositorio();
                    $Pelada = new Pelada($_POST['id_pelada']);

                    $Pelada->localizacao = $Localizacao->idLocalizacao;
                    $Pelada->nome = $_POST['nomePelada'];
                    $Pelada->descricao = $_POST['descricaoPelada'];
                    $Pelada->duracaoPartida = $_POST['tempoJogo'];
                    $Pelada->qtJogadores = $_POST['qtJogadores'];
                    $Pelada->sorteio = $_POST['sorteio'];
                    $Pelada->dataPartida = $_POST['dataPartida'];
                    $Pelada->horario = $_POST['horario'];
                    $Pelada->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                    $PeladaRepositorio->atualizarPelada($Pelada);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
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
                    $ListaPelada = PeladaRepositorio::buscarPelada(['p.fk_peladeiro ='.$_SESSION['id_usuario_logado']]);
                    foreach($ListaPelada as $pelada) {
                        $DataPelada = $pelada->data_pelada;
                        $novaData = date("d/m/Y", strtotime($DataPelada));
                        $html[] =  array('idPelada'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada, 'data_partida'=>$novaData, 'horario'=>$pelada->horario,'idLocalizacao'=>$pelada->fk_localizacao) ;
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
                    $EncontrarPelada= PeladaRepositorio::buscarPelada(['nome_cidade LIKE "%'.$_POST['cidade'].'%"']);
                    if(count($EncontrarPelada) > 0){
                        foreach($EncontrarPelada as $pelada) {
                            $novaData = date("d/m/Y", strtotime($pelada->data_pelada));
                            $horarioNovo = date("H:i", strtotime($pelada->horario));

                            $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada,'rua'=>$pelada->rua,'numero'=>$pelada->numero, 'quadra'=>$pelada->nome_quadra, 'bairro'=>$pelada->bairro,'cidade'=>$pelada->nome_cidade,'sigla'=>$pelada->sigla, 'data'=>$novaData, 'horario'=>$horarioNovo) ;
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
                    $Pelada = new Pelada($_POST['id_pelada']);
              
                    $id_pelada = $Pelada->idPelada;
                    $html = [];
                    $ListaPeladeiro = PeladeiroRepositorio::buscarPeladeiro();
                    foreach($ListaPeladeiro as $peladeiro) {
                        $buscaPelada = PeladaRepositorio::buscaGeralPelada(['p.fk_peladeiro ='.$peladeiro->id_usuario.' and p.fk_pelada = '.$_POST['id_pelada']]);

                        if(count($buscaPelada)>0){

                            foreach ($buscaPelada as $peladeiroPelada) {

                                if($peladeiroPelada->fk_peladeiro == $peladeiroPelada->id_usuario){
                                    $idCad= $peladeiroPelada->fk_peladeiro ;
                                }
                            }
                        }else{
                            $idCad = false;
                        }        
                        $html[] =  array('id'=>$peladeiro->id_usuario,'nome'=>$peladeiro->nome,'email'=>$peladeiro->email, 'idCad'=>$idCad);
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html,'id_pelada'=>$id_pelada)));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o peladeiro.")));
                }
            break;
            case 'adicionar_peladeiro':
            try
            {

                \Doctrine::beginTransaction();
                $PeladaRepositorio = new PeladaRepositorio();
                $Pelada = new Pelada($_POST['pelada']);
          
                $Pelada->idPelada = $_POST['pelada'];

                $peladeirosPost = $_REQUEST['peladeiro'];
                if ($peladeirosPost) {
                    foreach ($peladeirosPost as $valores) {

                        $Pelada->addPeladeiros(new Usuario($valores));
                        $buscaUsuario = UsuarioRepositorio::buscarUsuario(['id_usuario ='.$valores.' and ativo ='.true]);
                        foreach ($buscaUsuario as $usuario){
                            $email = $usuario->email;
                            $nome = $usuario->nome;
                            $senha = $usuario->senha;
                        }
                        $buscaPelada = PeladaRepositorio::buscarPelada(['id_pelada ='.$_POST['pelada']]);
                        foreach ($buscaPelada as $pelada) {
                            $cidade = $pelada->nome_cidade;
                            $bairro = $pelada->bairro;
                            $estado = $pelada->sigla;
                            $rua = $pelada->rua;
                            $numero = $pelada->numero;
                            $quadra = $pelada->nome_quadra;
                            $nome_pelada = $pelada->nome_pelada;
                            $novaData = date("d/m/Y", strtotime($pelada->data_pelada));
                            $horarioNovo = date("H:i", strtotime($pelada->horario));
                        }
                        $destinatarios = $email;
                        
                        $assuntoFormulario = 'Convocação - Mais Pelada';

                        $valores_convocacao_tpl = [
                            '%nome_site%' =>TITULO,
                            '%nome%' =>$nome,
                            '%formulario_titulo%' => $assuntoFormulario,
                            '%url_raiz_site%' => URL_RAIZ_SITE,
                            '%data_hora%' => date('d/m/Y H:i:s'),
                            '%senha%' => $senha,
                            '%data%' => $novaData,
                            '%hora%' => $horarioNovo,
                            '%email%' => $email,
                            '%pelada%' => $nome_pelada,
                            '%local%' =>  $quadra.' - '.$rua.' - '.$numero.' '.$bairro.', '.$cidade.' - '.$estado
                        ];
                        $Template = new TemplateEmail($valores_convocacao_tpl, 'convocacao');

                        $Email = new Email($destinatarios, ($assuntoFormulario), ($Template->getHtmlTemplates()));
                        $Email->ativar_html = true;
                        $Email->remetente = 'Mais Pelada';
                       
                        if(!$Email->enviar()){
                            \Doctrine::rollBack();
                            exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao notificar peladeiro')));
                        }
                    }
                    $PeladaRepositorio->salvarPeladeiroPelada($Pelada);  
                }
                \Doctrine::commit();     
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar peladeiro')));
            }
            break;
            case 'remover_peladeiro_pelada':
            try{
                \Doctrine::beginTransaction();
                $PeladaRepositorio = new PeladaRepositorio();
                $Peladeiro = new Peladeiro($_POST['id_peladeiro']);
                if($_POST['id_peladeiro']){
                    if(!$PeladaRepositorio->deletarPeladeiroPelada(['fk_peladeiro ='.$_POST['id_peladeiro'].' and fk_pelada = '.$_POST['id_pelada']])){
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'O peladeiro '.$Peladeiro->nome.' não está participando desta pelada')));
                    } else{
                        \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Peladeiro removida com sucessos')));
                    }
                    
                }  
            }catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao remover peladeiro')));
            }
            break;
            case 'enviar_solicitacao':
                try {
                    $dadosPelada = PeladaRepositorio::buscarPelada(['id_pelada ='.$_POST['id_pelada']]);
                    foreach ($dadosPelada as $pelada){
                        $emailCriador = $pelada->email;
                        $nomeCriador = $pelada->apelido ? $pelada->apelido : $pelada->nome;
                        $nomePelada = $pelada->nome_pelada;   
                    }
                    $dadosUsuario = PeladeiroRepositorio::buscarPeladeiro(['id_usuario ='.$_SESSION['id_usuario_logado'].' and ativo ='.true]);
                    foreach ($dadosUsuario as $usuario){
                        $nomeUsuario = $usuario->apelido ? $usuario->apelido : $usuario->nome;
                        $emailUsuario = $pelada->email;
                    }

                    $destinatarios = $emailCriador;
                    $assuntoFormulario = 'Novo peladeiro  - Mais Pelada';

                    $valores_integra_peladeiro_tpl = [
                        '%nome_site%' =>TITULO,
                        '%nome%' =>$nomeCriador,
                        '%formulario_titulo%' => $assuntoFormulario,
                        '%url_raiz_site%' => URL_RAIZ_SITE,
                        '%data_hora%' => date('d/m/Y H:i:s'),
                        '%nome_peladeiro%' => $nomeUsuario,
                        '%email_peladeiro%' => $emailUsuario,
                        '%pelada%' => $nomePelada
                    ];
                    $Template = new TemplateEmail($valores_integra_peladeiro_tpl, 'integrarPeladeiro');

                    $Email = new Email($destinatarios, ($assuntoFormulario), ($Template->getHtmlTemplates()));
                    $Email->ativar_html = true;
                    $Email->remetente = $nomeUsuario;

                    if(!$Email->enviar()){
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao notificar')));
                    } else{
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>'Solicitação enviada.')));
                    }
                } catch (Exception $ex) {
                    exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro')));
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
