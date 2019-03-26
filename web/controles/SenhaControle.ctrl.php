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
        
                      
        switch ($_REQUEST['acao']){
             case 'cadastra_senha':
                try{

                    if ($_POST['password'] != $_POST['passwordConfirm']) {
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'As senhas não conferem!')));
                    }
                    $tokenUrl = explode('=',$_SERVER['HTTP_REFERER']);

                    \Doctrine::beginTransaction();

                    $user = PeladaRepositorio::buscaGeralPelada(['p.token = "'.$tokenUrl[1].'" ']);
                    if(count($user)>0){
                        foreach ($user as $usuario) {
                            $id = $usuario->fk_peladeiro;
                            $expira  = $usuario->data_atual;
                        }

                        if($expira < date('Y-m-d H:i')){
                            \Doctrine::rollBack();
                            exit(json_encode(array('sucesso'=>false, 'mensagem'=>'Token expirado')));
                        }
                        $UsuarioRepositorio = new UsuarioRepositorio();
                        $senha = md5($_POST['password']);

                        $UsuarioRepositorio->adicionarSenha($id,$senha);
                        \Doctrine::commit();
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>'Senha cadastrada com sucesso')));
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
