<?php

/**
 * Gerencia a exibição da pagina do peladeiro.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class PeladeiroControle 
{
    #criando a função para o tratamento de ações a serem executadas no sistema
    public function tratarAcoes()
    {
      #verifica se existe o Requisição com o name acao na solicitação
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
            case 'adicionar':
            try
            {   # valida se existe uma imagem          
                if(isset($_FILES['imagemUsuario'])) {
                    $msg_erro = false;
                    # verifica o tamanho da imagem se for maior que 2MB é informado uma mensagem para o usuário
                    if ($_FILES['imagemUsuario']['size'] > TAMANHO_IMAGEM) {
                        exit(json_encode(["sucesso" => false,"mensagem" => "Imagem muito grande! O tamanho permitido é de " . UsuarioModelo::verificaTamanhoImagem(TAMANHO_IMAGEM) . "<br />"]));
                    }
           
                    if ($msg_erro) {
                        exit(json_encode(["sucesso" => false, "mensagem" => implode("<br>", $msg_erro)]));
                    }
                }
                
                \Doctrine::beginTransaction();
                #busca os campos time e posição e coloca na variavel
                $time = $_POST['time'];
                $posicao =  $_POST['posicao'];

                #instancia um objeto $PeladeiroRepositorio da classe PeladeiroRepositorio
                #instancia um objeto $Peladeiro da classe Peladeiro
                $PeladeiroRepositorio = new PeladeiroRepositorio();
                $Peladeiro = new Peladeiro();
                
                # verifica se o email do email peladeiro que esta sendo criado ja existe no banco de dados caso exista retorna uma mensagem se nao prossegue com o processo de criação
                $verificaEmail = $PeladeiroRepositorio::buscarPeladeiro(['email = "'.$_POST['emailPeladeiro'].'" ']);
                if(count($verificaEmail)>0){
                    exit(json_encode(["sucesso" => false,"mensagem" => "Peladeiro já está cadastrado, favor informar um e-mail diferente"]));
                } else {
                
                #gerando a url da imagem para salvar no banco de dados     
                    if($_POST['imagemUsuario']){
                        $imagem = pathinfo($_FILES['imagemUsuario']['name']);
                        $nomeImagem = Tratamentos::padraoUrl($imagem['filename']);
                        $url = URL_USUARIO.'/'. UsuarioModelo::PREFIXO_MINIATURA . $nomeImagem .'.' . $imagem['extension'];
                    }
                #Objeto Peladeiro recebe os posts (campos) enviados do formulario e insere em cada atributo.
                    $Peladeiro->setTime(new Time($time));
                    $Peladeiro->setPosicao(new Posicao($posicao));
                    $Peladeiro->nome = $_POST['nomePeladeiro'];
                    $Peladeiro->email = $_POST['emailPeladeiro'];
                    $Peladeiro->telefone = $_POST['telPeladeiro'];
                    $Peladeiro->data_nascimento = $_POST['dataNascimento'];
                #verifica se a url da imagem nao existir é criada uma url como uma imagem default 
                    $Peladeiro->url_imagem = isset($_FILES['imagemUsuario']['name']) ? $url : URL_USUARIO.'/'. UsuarioModelo::PREFIXO_MINIATURA . 'default.jpeg';

                    $Peladeiro->participacao = $_POST['participacao'];
                    $Peladeiro->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                #verifica se o metodo adionaPeladeiro da classe $PeladeiroRepositorio retorna true  se não retorna uma mensagem  
                    if(!$PeladeiroRepositorio->adicionaPeladeiro($Peladeiro)){
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao inserir dados')));
                    }
                #se existir uma imagem enviada pelo peladeiro ele envia para o metodo de tratamento de imagens redimensionando ela proporcionalmente para ser salva no servidor
                    if(isset($_FILES['imagemUsuario'])){
                        UsuarioModelo::salvaFoto($_FILES['imagemUsuario']);
                    }
                # Salva o peladeiro inserido na tabela de grupo do peladeiro onde é informado o novo criador e o peladeiro
                    $PeladeiroRepositorio->inserirGrupoPeladeiro($Peladeiro->idPeladeiro, $_SESSION['id_usuario_logado']);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
                }   
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar pelada')));
            }
            break;
            case 'buscar_dados_para_edicao':
                try{
                    $Peladeiro = new Peladeiro($_POST['id_peladeiro']);
                    if($Peladeiro->posicao){
                        $Posicao = new Posicao($Peladeiro->posicao);
                    }
                    if($Peladeiro->timeFutebol)
                    $Time = new Time($Peladeiro->timeFutebol);
                    $saida = array();

                    $saida['idPeladeiro'] = $Peladeiro->idPeladeiro;
                    $saida['nome'] = $Peladeiro->nome;
                    $saida['email'] = $Peladeiro->email;
                    $saida['telefone'] = $Peladeiro->telefone;
                    $saida['data_nascimento'] = $Peladeiro->data_nascimento ? Tratamentos::converteData($Peladeiro->data_nascimento) : null;
                    $saida['posicao'] = $Peladeiro->posicao ? $Peladeiro->posicao : null ; 
                    $saida['time'] = $Peladeiro->timeFutebol ? $Peladeiro->timeFutebol :null;
                    $saida['participacao'] = $Peladeiro->participacao;
                    $saida['imagemPeladeiro'] = URL_USUARIO. '/'. UsuarioModelo::PREFIXO_MINIATURA . $Peladeiro->url_imagem;


                    exit(json_encode($saida));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false)));
                }
            break;
            case 'atualizar':
                try{
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

                $buscarPeladeiro = PeladeiroRepositorio::buscarPeladeiro(['email = "millacnicolau@gmail.com" and ativo ='.true]);

                $time = $_POST['time'];
                $posicao =  $_POST['posicao'];

                $PeladeiroRepositorio = new PeladeiroRepositorio();
                $Peladeiro = new Peladeiro($_POST['id_peladeiro']);
                if($_POST['imagemUsuario']){
                    $imagem = pathinfo($_FILES['imagemUsuario']['name']);
                    $nomeImagem = Tratamentos::padraoUrl($imagem['filename']);
                    $url = $nomeImagem .'.' . $imagem['extension'];
                }
                
                $Peladeiro->setTime(new Time($time));
                $Peladeiro->setPosicao(new Posicao($posicao));
                $Peladeiro->nome = $_POST['nomePeladeiro'];
                $Peladeiro->email = $_POST['emailPeladeiro'];
                $Peladeiro->telefone = $_POST['telPeladeiro'];
                $Peladeiro->data_nascimento = $_POST['dataNascimento'];
                $Peladeiro->url_imagem = isset($_FILES['imagemUsuario']['name']) ? $url :$Peladeiro->url_imagem;
                $Peladeiro->participacao = $_POST['participacao'] ? $_POST['participacao'] : 'mensalista';
                $Peladeiro->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                if(isset($_FILES['imagemUsuario'])){
                    UsuarioModelo::salvaFoto($_FILES['imagemUsuario']);
                }
                $PeladeiroRepositorio->atualizarPeladeiro($Peladeiro);
                    
                \Doctrine::commit();
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
               
                } catch (Erro $E) {
                \Doctrine::rollBack();
                 exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao atualizar dados da pelada')));
                }
            break;
            case 'remover_peladeiro':
                try{

                    \Doctrine::beginTransaction();
                    $PeladeiroRepositorio = new PeladeiroRepositorio();

                    $dadosPeladeiro = PeladeiroRepositorio::buscarGrupoPeladeiro(['p.id_peladeiro_parceiro ='.$_POST['id_peladeiro']]);

                    foreach ($dadosPeladeiro as $dados) {
                        $criador = $dados->fk_criador;
                        $id_usuario = $dados->id_usuario;
                    }
                    $infoPeladeiros = PeladaRepositorio::buscaGeralPelada(['pe.fk_criador ='.$_SESSION['id_usuario_logado'].' and fk_peladeiro ='.$id_usuario.' and p.confirmacao = 1' ]);
                    if(count($infoPeladeiros) > 0){
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Remova o peladeiro da pelada antes de remove-lo completamente')));
                    }
                    $PeladeiroRepositorio->deletarPeladeiro($_POST['id_peladeiro']);
                    if($_SESSION['id_usuario_logado'] == $criador){

                        $UsuarioRepositorio = new UsuarioRepositorio();
                        $UsuarioRepositorio->deletarUsuario($id_usuario);
                    }

                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Peladeiro removido com sucessos')));
                    
                } catch(Erro $E){
                    \Doctrine::rollBack();
                   exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao remover pelada')));
                }
            break;
            case 'lista_peladeiro':
                try{
                    $html = [];
                    $ListaPeladeiro = PeladeiroRepositorio::buscarGrupoPeladeiro(['p.fk_parceiro ='.$_SESSION['id_usuario_logado']]);
                    foreach($ListaPeladeiro as $peladeiro) {

                        $html[] =  array('id'=>$peladeiro->fk_peladeiro,'nome'=>$peladeiro->nome, 'email'=>$peladeiro->email) ;
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
            case 'buscar_peladeiro':
                try{
                    
                    $html = [];
                    if(!isset($_POST['email']) || $_POST['email']== ""){
                        exit(json_encode(['sucesso'=>false, "mensagem" => "Informe um e-mail."]));
                    }
                    $ListaPeladeiro = PeladeiroRepositorio::buscarGrupoPeladeiro(['u.email LIKE "%'.$_POST['email'].'%" and p.fk_parceiro<>'.$_SESSION['id_usuario_logado']]);
                    if(count($ListaPeladeiro) > 0){
                        foreach($ListaPeladeiro as $peladeiro) {
                            $html[] =  array('id'=>$peladeiro->id_usuario,'nome'=>$peladeiro->nome, 'email'=>$peladeiro->email) ;
                        }
                        exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                    } else{
                        exit(json_encode(['sucesso'=>false, "mensagem" => "Não foi encontrado nenhum peladeiro."]));
                    }
                }catch(Erro $E){
                    exit(json_encode(['sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar o peladeiro."]));
                }
            break;
            
            case 'adicionar_peladeiro':
                try{
                    $parceiro = $_SESSION['id_usuario_logado'];
                    $peladeiro = $_POST['id_peladeiro'];
                    \Doctrine::beginTransaction();
                    $Dados = new PeladeiroRepositorio();
                    $Dados->inserirGrupoPeladeiro($peladeiro, $parceiro);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));

                } catch (Erro $E) {
                  \Doctrine::rollBack();
                  exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao adicionar peladeladeiro a lista')));
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