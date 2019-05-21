<div id="esqueciSenha" class="col-sm-12 col-lg-5 m-auto border rounded shadow-lg py-4 bg-white text-center">

<form class="form-horizontal mx-auto d-block px-3" action="esqueciMinhaSenha" method="post" name="form_esqueci_senha" id="form_esqueci_senha" >
    <h4>Esqueceu a senha?!</h4>
    <i class="far fa-5x fa-meh-rolling-eyes my-3 text-muted"></i>
    <p>
      Informe seu e-mail que enviaremos uma nova.<br />Em caso de dúvidas
      entre em contato com o adminstrador do sistema.
    </p>
    <div class="form-group">
        <label for="inputEmail" class="control-label sr-only">Email</label>
        <input id="email" name="email" class="form-control" placeholder="Digite seu E-mail" type="email" required autofocus>
     </div>
    <input name="acao" value="recuperar_senha" id="acao_recuperar_senha" type="hidden" />
    <button type="submit" class="btn btn-success mx-2 btn-default px-4" id ="botao-enviar">Enviar</button>
    <button type="submit" class="btn btn-danger mx-2 btn-default px-4" id ="botao-cancelar">Cancelar</button>
</form>
  
</div> 
<div id="recuperarSenha">

 <form class="form-signin" action="" method="post" name="recuperar_senha" id="recuperar_senha" style="display:none">
  <div class="form-group">
            <label for="inputPassword" class="control-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required="" placeholder="Digite sua Senha">
            <div class="progress">
            <span id="progresso" class="progress-bar" role="progressbar" aria-valuemax="100"></span>
            </div>
          </div>

          <div class="form-group">
            <label for="inputPassword" class="control-label">Confirme a senha</label>
            <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" required="" placeholder="Confirme a senha">
          </div>
       <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-enviar">Enviar</button>

  
</div>
