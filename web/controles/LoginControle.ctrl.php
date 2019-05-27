<?php

/**
 * Gerencia a exibição da página de login.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class LoginControle extends ControlaModelos
{
    public function tratarAcoes()
    {
       if(isset($_REQUEST['acao']));
        switch($_REQUEST['acao']){
            case 'logar':
                try{
                    $buscaUsuario = UsuarioRepositorio::buscarUsuario(['email = "'.$_POST['email'].'" and ativo ='.true]);
                    if(count($buscaUsuario)>0){
                        foreach($buscaUsuario as $usuario){
                            $nome = $usuario->nome;
                            $email = $usuario->email;
                            $senha = $usuario->senha;
                            $id = $usuario->id_usuario;
                            $ativo = $usuario->ativo;
                        }
                    }else {
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Usuario não encontrado.')));
                    }

                    $_POST['id'] = $id;
                    $nome = explode(' ',$nome);

                    if($_POST['email'] != $email || md5($_POST['password']) != $senha) {
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'Usuario ou senha incorreta')));
                    }
                    if($ativo == 1) {
                        if($_POST['email'] == $email && md5($_POST['password']) == $senha) {
                            $_SESSION['id_usuario_logado'] = $id;
                            $_SESSION['nome_usuario_logado'] = $nome[0];
                            if(isset($_POST['_memorizar']))
                            {
                                setcookie($_POST['email'],  $_POST['password'] ,time()+60*60*24*30);
                            }
                            exit(json_encode(array('sucesso'=>true)));
                        } 
                    } else{
                        exit(json_encode(array('sucesso'=>false, 'mensagem'=>'Usuário desativado, favor entrar em contato com o administrador do sistema')));
                    }
                }catch(Error $E){
                    exit(json_encode(array("erro" => true, "sucesso" => false)));
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
            require PATH_RAIZ . '/visualizacoes/login.php';

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
