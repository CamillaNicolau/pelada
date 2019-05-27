<?php

 /**
 * Gerencia a exibição da página de cadastro de usuario.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
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
                $UsuarioRepositorio = new UsuarioRepositorio();
                $Usuario = new Usuario();
                $verificaEmail = $UsuarioRepositorio::buscarUsuario(['email = "'.$_POST['emailUsuario'].'" ']);
                if(count($verificaEmail)>0){
                    exit(json_encode(["sucesso" => false,"mensagem" => "Usuário já está cadastrado, favor nformar um e-mail diferente"]));
                } else{
                
                    \Doctrine::beginTransaction();

                    if(isset($_FILES['imagemUsuario'])){
                      $imagem = pathinfo($_FILES['imagemUsuario']['name']);
                      $nomeImagem = Tratamentos::padraoUrl($imagem['filename']);
                      $url = URL_USUARIO.'/'. UsuarioModelo::PREFIXO_MINIATURA . $nomeImagem .'.' . $imagem['extension'];
                    }

                    $Usuario->nome = $_POST['nomeUsuario'];
                    $Usuario->email = $_POST['emailUsuario'];
                    $Usuario->senha = md5($_POST['password']);
                    $Usuario->apelido = $_POST['apelidoUsuario'];
                    $Usuario->sexo = ($_POST['sexo'] == 'feminino')? 'f' :'m';
                    $Usuario->data_nascimento = $_POST['dataNascimento'];
                    $Usuario->urlImagem = isset($_FILES['imagemUsuario']['name']) ? $url : URL_USUARIO.'/'. UsuarioModelo::PREFIXO_MINIATURA . 'default.jpeg';
                    if($UsuarioRepositorio->adicionaUsuario($Usuario)){
                        if(isset($_FILES['imagemUsuario'])){
                            UsuarioModelo::salvaFoto($_FILES['imagemUsuario']);
                        }
                        $UsuarioRepositorio->adicionarParceiro((int)$Usuario->idUsuario, (int)$Usuario->idUsuario);
                        \Doctrine::commit();
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));
                    } else{
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar usuáriozz')));
                    }
                }
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar usuário')));
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
