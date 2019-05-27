<?php

/**
 * Gerencia a exibição da página Esqueci minha senha.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class EsqueciMinhaSenhaControle
{
    public function tratarAcoes(){
      
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao']){
            case 'recuperar_senha':
                try {
                    $usuario_recuperar = UsuarioRepositorio::buscarUsuario(['email ="'.$_POST['email'].'" and ativo ='.true]);
                    
                    foreach ($usuario_recuperar as $usuario){
                        $nome = $usuario->nome;
                        $email = $usuario->email;
                        $id = $usuario->id_usuario;
                    } 
                    if($email){
                        $destinatarios = $_POST['email'];
                        $senha = Tratamentos::gerarSenha();
                        $assuntoFormulario = 'Recuperar Senha - Mais Pelada';

                        $valores_recuperarSenha_tpl = [
                            '%nome_site%' =>TITULO,
                            '%nome%' =>$nome,
                            '%formulario_titulo%' => $assuntoFormulario,
                            '%url_raiz_site%' => URL_RAIZ_SITE,
                            '%data_hora%' => date('d/m/Y H:i:s'),
                            '%senha%' => $senha,
                            '%email%' => $_POST['email']
                        ];
                        $Template = new TemplateEmail($valores_recuperarSenha_tpl, 'recuperarSenha');

                        $Email = new Email($destinatarios, ($assuntoFormulario), ($Template->getHtmlTemplates()));
                        $Email->ativar_html = true;
                        $Email->remetente = 'Mais Pelada';

                        $Email->enviar();

                        
                        $UsuarioRepo = new UsuarioRepositorio();
                        $Usuario = new Usuario($id);
                        $Usuario->senha = md5($senha);

                        $UsuarioRepo->atualizarUsuario($Usuario);
                        
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>'Enviado com sucesso')));
                        \Doctrine::commit();
                    }else{
                        \Doctrine::rollBack();
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'E-mail inexistente!')));
                    }
                    
                } catch (Exception $ex) {
                    \Doctrine::rollBack();
                    exit(json_encode(array('sucesso'=>false)));
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
            require PATH_RAIZ . '/visualizacoes/esqueciMinhaSenha.php';

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
