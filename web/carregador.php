<?php

/**
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

# Evitar acesso direto.
if(!defined('PATH_RAIZ')) {
    exit;
}

// Funções globais

require PATH_RAIZ . '/funcoes/global.php';


$valor = ($_GET['acao']) ? Tratamentos::index($_GET['acao']) : 'Index';
// if(!isset($_SESSION['id_usuario_logado']) && $valor != 'Login' && $valor != 'Usuario' && $valor != 'EsqueciMinhaSenha')
// {
// var_dump('aqui');
//   exit();
//   header('location: '.URL_RAIZ_SITE.'/login');
//   exit();
// }

// Carrega a aplicação se o $_GET for true.
if(isset($inst)) {
    $IniciaTeste = new Inicio($valor);
}
