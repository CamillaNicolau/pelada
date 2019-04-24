<?php

/**
 * Função para carregar automaticamente todas as classes.
 * Padrão para as classes [nomeDoArquivo].class.php
 */

require PATH_RAIZ . "/util/Tratamentos.class.php";
require PATH_RAIZ . "/util/Inicio.class.php";
require PATH_RAIZ . "/util/ControlaModelos.class.php";
require PATH_RAIZ . "/util/Imagem.class.php";
require PATH_RAIZ . "/util/Email.class.php";
require PATH_RAIZ . "/util/TemplateEmail.class.php";
require PATH_RAIZ . "/modelos/entidades/Usuario.class.php";
require PATH_RAIZ . "/modelos/entidades/Time.class.php";
require PATH_RAIZ . "/modelos/entidades/Posicao.class.php";
require PATH_RAIZ . "/modelos/entidades/Pelada.class.php";
require PATH_RAIZ . "/modelos/entidades/Peladeiro.class.php";
require PATH_RAIZ . "/modelos/entidades/Estado.class.php";
require PATH_RAIZ . "/modelos/entidades/Cidade.class.php";
require PATH_RAIZ . "/modelos/entidades/Localizacao.class.php";
require PATH_RAIZ . "/modelos/entidades/Financeiro.class.php";
require PATH_RAIZ . "/modelos/repositorios/Doctrine.class.php";
require PATH_RAIZ . "/modelos/repositorios/TimeRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/PosicaoRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/UsuarioRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/PeladaRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/PeladeiroRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/EstadoRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/CidadeRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/LocalizacaoRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/FinanceiroRepositorio.class.php";
require PATH_RAIZ . "/modelos/repositorios/NotificacaoRepositorio.class.php";
require PATH_RAIZ . "/modelos/servicos/UsuarioModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/EsqueciMinhaSenhaModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/HomeModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/LoginModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/PeladaModelo.class.php";
require PATH_RAIZ . "/modelos/servicos/PerfilModelo.class.php";
require "../bibliotecas/doctrine/vendor/autoload.php";
require "../bibliotecas/phpmailer/vendor/PHPMailerAutoload.php";
require "../bibliotecas/emogrifier/vendor/EmogriferAutoload.php";
