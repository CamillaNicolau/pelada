<!DOCTYPE html>
<html lang="pt-br">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>+Pelada</title>
      <link type="text/css" href="./visualizacoes/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/bootstrap/css/bootstrap-reboot.min.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/bootstrap/css/sb-admin.min.css" rel="stylesheet"/>
      <link type="text/css" href="./visualizacoes/css/sweetalert.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/css/complemento.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/css/geral.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/css/menu.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/fontes/fontawesome-free-5.1.0-web/css/all.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/css/<?php echo Inicio::getNomePaginaAtual(); ?>.css" rel="stylesheet"/>
    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <a class="navbar-brand mr-1" href="#">Mais Pelada</a>
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge badge-danger">9+</span>
                    </a>
                </li>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configurações</a>
                        <a class="dropdown-item" href="perfil"><i class="fas fa-user"></i> Perfil</a>
                        <a class="dropdown-item" href="#"><i class="fab fa-telegram-plane"></i> Contato</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="wrapper">
            <ul class="sidebar navbar-nav">
                <li class="nav-item"><a  class="nav-link" href="pelada"><i class="fas fa-futbol"></i> Pelada</a></li>
                <li class="nav-item"><a class="nav-link"  href="peladeiro"><i class="fa fa-users"></i> Peladeiro</a></li>
                <li class="nav-item"><a class="nav-link"  href="#"><i class="far fa-calendar"></i> Placares</a></li>
                <li class="nav-item"><a class="nav-link"  href="#"><i class="fas fa-dollar-sign"></i> Financeiro</a></li>
                <li class="nav-item"><a class="nav-link"  href="#"><i class="far fa-file"></i> Relatório</a></li>

            </ul>
            <div id="content-wrapper">
                <div class="container-fluid">   