<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class SenhaControle extends ControlaModelos
{
    public function tratarAcoes(){
      
        if(isset($_REQUEST['acao']));
         var_dump($_GET);
                      
        switch ($_REQUEST['acao']){
             case 'cadastra_senha':
                try{
                  var_dump($_GET);
                            exit();

                    if ($_POST['password'] != $_POST['passwordConfirm']) {
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'As senhas não conferem!')));
                    }

                    $buscaUsuario = PeladaRepositorio::buscaGeralPelada(['p.token = "'.$_GET['token'].'" and u.ativo ='.true]);
                    if(count($buscarUsuario)>0){
                        foreach ($buscarUsuario as $usuario) {
                           
                        }
                        // \Doctrine::beginTransaction();
                        // $UsuarioRepositorio = new UsuarioRepositorio();
                        // $Usuario = new Usuario();

                        // $Usuario->senha = md5($_POST['password']);
                        // $UsuarioRepositorio->atualizarUsuario($Usuario,false);
                        // \Doctrine::commit();
                        // exit(json_encode(array('sucesso'=>true,'mensagem'=>'Senha cadastrada com sucesso')));
                    }else{
                        \Doctrine::rollBack();
                        exit(json_encode(array('sucesso'=>false, 'mensagem'=>'Usuário não cadastrado no sistema, caso queira se cadastrar acesse  <a href="usuario">Cadastro</a>')));
                    }
                }catch(Error $E){
                    \Doctrine::rollBack();
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
            require PATH_RAIZ . '/visualizacoes/senha.php';

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
