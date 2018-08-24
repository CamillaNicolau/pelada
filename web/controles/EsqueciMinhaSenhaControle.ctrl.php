<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class EsqueciMinhaSenhaControle extends ControlaModelos
{
    public function tratarAcoes(){
      
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao']){
            case 'recuperar_senha':
                try {

                    $usuario_recuperar = UsuarioRepositorio::buscarUsuario($_POST['email']);
                    if($usuario_recuperar){
                        
                    }else{
                        exit(json_encode(array('sucesso'=>false,'mensagem'=>'E-mail inexistente!')));
                    }
                    
                } catch (Exception $ex) {
                    
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
            $Modelo = $this->carregarModelo('EsqueciMinhaSenhaModelo');

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
