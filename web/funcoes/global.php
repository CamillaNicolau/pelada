<?php

/**
 * Função para carregar automaticamente todas as classes.
 * Padrão para as classes [nomeDoArquivo].class.php
 */

require PATH_RAIZ . "/util/Tratamentos.class.php";
require PATH_RAIZ . "/util/Inicio.class.php";
require PATH_RAIZ . "/util/ControlaModelos.class.php";
require PATH_RAIZ . "/util/Imagem.class.php";
require PATH_RAIZ . "/modelos/entidades/Usuario.class.php";
require PATH_RAIZ . "/modelos/entidades/Time.class.php";
require PATH_RAIZ . "/modelos/entidades/Posicao.class.php";
require PATH_RAIZ . "/modelos/entidades/Pelada.class.php";
require PATH_RAIZ . "/modelos/repositorios/Doctrine.class.php";
require PATH_RAIZ . "/modelos/repositorios/TimeRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/PosicaoRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/UsuarioRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/PeladaRepositorio.class.php";
require PATH_RAIZ . "/modelos/servicos/UsuarioModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/EsqueciMinhaSenhaModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/HomeModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/LoginModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/PeladaModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/PerfilModelo.class.php";
require "../vendor/autoload.php";
