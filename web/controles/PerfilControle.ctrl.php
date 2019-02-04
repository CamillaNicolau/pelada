<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class PerfilControle extends ControlaModelos
{

    public function tratarAcoes()
    {
      if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
          case 'buscar_dados_para_edicao':
            try{

              $Usuario = new Usuario($_SESSION['id_usuario_logado']);
              $saida = array();
              
              $saida['idUsuario'] = $Usuario->idUsuario;
              $saida['imagemUsuario'] = URL_USUARIO. '/'. UsuarioModelo::PREFIXO_MINIATURA . $Usuario->urlImagem; 
              $saida['nomeUsuario'] = $Usuario->nome;
              $saida['emailUsuario'] = $Usuario->email;
              $saida['apelidoUsuario'] = $Usuario->apelido;
              $saida['sexo'] = $Usuario->sexo;

         
              exit(json_encode($saida));
            } catch(Erro $E){
               exit(json_encode(array('sucesso'=>false)));
            }
            break;
         case 'atualizar':
          try{
            
            if (isset($_FILES['imagemUsuario'])) {
                $msg_erro = false;
                    if ($_FILES['imagemUsuario']['size'] > TAMANHO_IMAGEM) {
                        Util::exitJson(["sucesso" => false,"mensagem" => "Imagem muito grande! O tamanho permitido é de " . UsuarioModelo::verificaTamanhoImagem(TAMANHO_IMAGEM) . "<br />"]);
                    }
                    if ($_FILES['imagemUsuario']['error'] == UPLOAD_ERR_NO_FILE) {
                    $file = false;
                } else if ($_FILES['imagemUsuario']['error'] == UPLOAD_ERR_OK) {
                    $file = $_FILES['imagemUsuario'];
                } else {
                   exit(json_encode(["sucesso" => false, "mensagem" => "Falha no envio do arquivo."]));
                }
            } else {
                $file = false;
            }

            $UsuarioRepositorio = new UsuarioRepositorio();
            $Usuario = new Usuario($_SESSION['id_usuario_logado']);
            if($_FILES['imagemUsuario']){
                $imagem = pathinfo($_FILES['imagemUsuario']['name']);
                $nomeImagem = Tratamentos::padraoUrl($imagem['filename']);
                $url = $nomeImagem .'.' . $imagem['extension'];
            }
            $Usuario->nome = $_POST['nomeUsuario'];
            $Usuario->email = $_POST['emailUsuario'];
            $Usuario->apelido = $_POST['apelidoUsuario'];
            $Usuario->urlImagem = isset($_FILES['imagemUsuario']['name']) ? $url :$Usuario->urlImagem;

            if($_POST['password'] != "" ){
              $Usuario->senha = md5($_POST['password']); 
            }
                      
            $UsuarioRepositorio->atualizarUsuario($Usuario,$file);

            exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
          \Doctrine::commit();
          } catch (Erro $E) {
          \Doctrine::rollBack();
           exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao atualizar dados da pelada')));
          }
          break;
          case 'busca_dados_usuario':
            try{
              
              $Usuario = new Usuario($_SESSION['id_usuario_logado']);
              $retorno = array();
              $retorno['idUsuario'] = $Usuario->idUsuario;
              $retorno['imagemUsuario'] = URL_USUARIO. '/'. UsuarioModelo::PREFIXO_MINIATURA . $Usuario->urlImagem;
              $retorno['nomeUsuario'] = $Usuario->nome;
              
              exit(json_encode($retorno));
            } catch (Erro $E){
              
            }
            break;
            case "desativar":
              try
              {
                  if(UsuarioRepositorio::desativar($_SESSION['id_usuario_logado'])){
                     exit(json_encode(["sucesso" => true, "mensagem" => "Desativado com sucesso"]));
                  } else {
                      exit(json_encode(["sucesso" => false, "erro" => true, "mensagem" => 'Erro ao desativar usuário']));
                  }
              }
              catch(Excecao $r)
              {
                  exit(json_encode(["sucesso" => false, "erro" => true, "mensagem" => 'Erro ao desativar usuário']));
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
            $Modelo = $this->carregarModelo('PerfilModelo');
          
            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/perfil.php';

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
