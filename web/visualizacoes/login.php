<div id="login">
  <form class="form-signin" action="login" method="post" name="form_login" id="form_login" >
    <fieldset>
      <body class="text-center">
       <div class="form-group">
        <label for="inputEmail" class="sr-only">Email</label>
        <input id="email" name="email" class="form-control" placeholder="Digite seu E-mail" required autofocus>
      </div>
      <div class="form-group">
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Digite sua Senha..." required>
      </div>
      <div class="checkbox">
        <label><input name="_memorizar" type="checkbox" value="remember-me"> Manter conectado </label>
      </div>
     <input name="id" value="" id="id_usuario" type="hidden" />
     <input name="acao" value="logar" id="acao_logar" type="hidden" />
     <button type="submit" class="btn btn-lg btn-success btn-block" id ="botao-entrar">Entrar</button>
    </fieldset>
  </form>
  <form class="form-signin" action="login" method="post" name="form_cadastrar_senha" id="form_cadastrar_senha" style="display: none">
    <div class="form-group">
      <label for="inputPassword" class="col-md-6 control-label">Informe a nova senha</label>
      <div class="col-md-12">
          <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua Senha">
          <div class="progress">
              <span id="progresso" class="progress-bar" role="progressbar" aria-valuemax="100"></span>
          </div>
      </div>
  </div>
  <div class="form-group">
      <label for="inputPassword" class="col-md-4 control-label">Confirme a senha</label>
      <div class="col-md-12">
          <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Confirme a senha">
      </div>
  </div>
  <input name="acao" value="cadastrar_senha" id="acao" type="hidden" />
  <button type="submit" class="btn btn-primary default" id ="botao-salvar">Salvar</button>
  </form>
    <div class="box_link"><a href="esqueciMinhaSenha">Esqueci minha senha</a></div>
  
    <p class="dados-cadastro">
        
        <small>Não é cadastrado? 
            <a href="usuario" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Entre com seu login">Clique aqui</a>
        </small>
    </p>
   
</div>


