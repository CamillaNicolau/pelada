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
      <link type="text/css" src="./visualizacoes/css/<?php echo Inicio::getNomePaginaAtual(); ?>.css" rel="stylesheet"/>
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
                        <a class="dropdown-item" href="perfil">Perfil</a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">Sair</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="wrapper">
            <ul class="sidebar navbar-nav">
                <li><a href="pelada"><i class="fa fa-users"></i> Pelada</a></li>
                <li><a href="peladeiro"><i class="fa fa-users"></i> Peladeiro</a></li>
                <li><a href="placar"><i class="fa fa-calendar-o"></i> Placares</a></li>
                <li><a href="financeiro"><i class="fa fa-dollar"></i> Financeiro</a></li>
            </ul>
            <div id="content-wrapper">
                <div class="container-fluid">   