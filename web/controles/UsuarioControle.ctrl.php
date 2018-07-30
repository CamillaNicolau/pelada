<?php

 /**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class UsuarioControle extends ControlaModelos
{
    public function tratarAcoes(){
      
      if(isset($_REQUEST['acao']));
      switch ($_REQUEST['acao'])
      {
        case 'adicionar':
        try
        {
          
    
            if ($_POST['password'] != $_POST['passwordConfirm']) {
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'As senhas não conferem!')));
            }
          
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
          $UsuarioRepositorio = new UsuarioRepositorio();
          $Usuario = new Usuario();
          
          $Usuario->nome = $_POST['nomeUsuario'];
          $Usuario->email = $_POST['emailUsuario'];
          $Usuario->senha = base64_encode($_POST['password']);
          $Usuario->apelido = $_POST['apelidoUsuario'];
          $Usuario->sexo = $_POST['sexo'];
          $Usuario->setTime(new Time($time));
          $Usuario->setPosicao(new Posicao($posicao));
          $Usuario->urlImagem = isset($_FILES['imagemUsuario']['name']) ? $_FILES['imagemUsuario']['name'] :null;
         
          $UsuarioRepositorio->adicionaUsuario($Usuario);
          if(isset($_FILES['imagemUsuario'])){
            UsuarioModelo::salvaFoto($_FILES['imagemUsuario']);
          }
          
          exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
          \Doctrine::commit();
        } catch (Erro $E) {
          \Doctrine::rollBack();
          exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar usuário')));
        }
        break;
        case 'lista_time':
          try{
            $html = [];
            $ListaTime = TimeRepositorio::buscarTime();
            foreach($ListaTime as $time) {
              $html[] = array('id'=>$time->idTime, 'nome'=>$time->nome);
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
               $htmlPosicao[] = array('id'=>$posicao->idPosicao, 'nome'=>$posicao->nome) ;
            }
            exit(json_encode(['sucesso'=>true, 'html'=>$htmlPosicao]));
          } catch (Erro $E) {
            exit(json_encode(['sucesso'=>false]));
          }
      }
    }
    public function getHtml()
    {
        try
        {
             /*
             * Carrega o modelo da página
             */
            $Modelo = $this->carregarModelo('UsuarioModelo');

            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/cabecalho.php';
           
            /*
             * Conteúdo
             */
            require PATH_RAIZ . '/visualizacoes/usuario.php';

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
