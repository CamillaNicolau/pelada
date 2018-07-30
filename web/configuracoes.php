<?php

/**
 * Configurações gerais do sistema
 * 
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

/**
 * 
 * Configurações Gerais.
 */
define('BD_USER','root');
define('BD_PASS','patetas');
define('BD_HOST' ,'localhost');
define('BD_NAME','chute_certo');
if (!defined('BD_DEBUG')) {
    define('BD_DEBUG', false);
}

if (!defined('BD_PERSISTENT')) {
    define('BD_PERSISTENT', false);
}

define('PATH_RAIZ' , dirname( __FILE__ ));
# URL Raiz do Site.
define('URL_RAIZ_SITE', 'http://chute_certo-millacnicolau554120.codeanyapp.com/web');
# Título principal do Sistema.
define("TITULO", "Chute Certo");

##### constantes #####
define('TAMANHO_IMAGEM','2097152');
define("IMAGEM_ORIGINAL_MAX_LARGURA", 1280);
define("IMAGEM_ORIGINAL_MAX_ALTURA", 960);
define("IMAGEM_MINI_LARGURA", 200);
define("IMAGEM_MINI_ALTURA", 150);
define('MIN_JOGADORES','8');
define("PATH_USUARIO", PATH_RAIZ."/visualizacoes/imagens/usuario");
define("URL_USUARIO", URL_RAIZ_SITE."/visualizacoes/imagens/usuario");


/**
 * 
 * Carrega o carregador.php, responsável por carregar
 * a aplicação completa.
 */
if(isset($inicio)) {
	$inst = true;
}

require_once PATH_RAIZ . '/carregador.php';