<?php

/**
 * Gerencia a saido do usuario no sistema.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class LogoutControle
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