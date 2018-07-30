<?php
class LogoutControle extends ControlaModelos
{
    public function tratarAcoes()
    {
      $token = md5(session_id());
      if(isset( $_SESSION['id_usuario_logado'])) {
         session_destroy();
         header("location: login");
         exit();
        }
    }
    public function getHtml()
    {
        try
        {
            /*
             * Carrega o modelo da página
             */
          //  $Modelo = $this->carregarModelo('LogoutModelo');

            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/cabecalho.php';

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