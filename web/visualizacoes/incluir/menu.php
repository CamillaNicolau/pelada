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
      <link type="text/css" href="./visualizacoes/css/geral.min.css" rel="stylesheet" />
       <!--    <link type="text/css" href="./visualizacoes/css/style.css" rel="stylesheet" /> 
      <link type="text/css" href="./visualizacoes/css/menu.css" rel="stylesheet" /> -->
      <link type="text/css" href="./visualizacoes/fontes/fontawesome-free-5.1.0-web/css/all.css" rel="stylesheet" />
      <link type="text/css" href="./visualizacoes/css/<?php echo Inicio::getNomePaginaAtual(); ?>.css" rel="stylesheet"/>
      
    </head>
    <body>
        <div class="container container-fluid h-100 mw-100">
            <div class="row justify-content-center pr-3">
                    <!--<img src="./visualizacoes/imagens/logo.jpg" alt="futebol">;-->
                    <nav id="navbar-fixed" class="col-lg-2 bg-primary sticky-top d-flex align-items-start navbar navbar-dark">
                        <div class="form-group" style="text-align: center" >
                            <label>
                                <input type="file"name="imagemUsuario" class="custom-file-input ">
                                <div id="imagem-perfil-menu">  
                                </div>
                            </label>
                        </div>
                        <ul class="nav navbar-nav text-light w-100">
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1"  href="inicio"><i class="fas fa-home"></i></i> Inicio</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1"  href="pelada"><i class="far fa-futbol"></i> Pelada</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1" href="peladeiro"><i class="fa fa-users"></i> Peladeiro</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1" href="#"><i class="far fa-calendar"></i> Partida</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1"  href="financeiro"><i class="fas fa-hand-holding-usd"></i> Financeiro</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1" href="#"><i class="fas fa-file-alt"></i>  Relatório</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1" href="perfil"><i class="fas fa-user"></i>  Meus dados</a></li>
                          <li class="nav-item"><a class="btn btn-default text-left text-light d-block p-1" href="logout"><i class="fas fa-sign-out-alt"></i>  sair</a></li>
                        </ul>
                        <div class="w-100 d-flex flex-column flex-nowrap justify-content-center align-items-center text-light align-self-end">
                            <div class="col-xs-3">
                             © 2018 Mais pelada
                            </div>

                            <div class="logo-rodape col-xs-3">
                              <img src="./visualizacoes/imagens/cn_camilla_nicolau.png" alt="Mais pelada" width="150" height="50">
                              <!--                     <img src="./visualizacoes/imagens/camilla.png" alt="">         -->

                            </div>
                        </div>
                    </nav>
                
