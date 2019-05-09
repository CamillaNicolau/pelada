<div id="login" class="col-sm-12 col-lg-4 m-auto border rounded shadow-lg py-4 bg-white text-center">
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
     <button type="submit" class="btn btn-m btn-success btn-block" id ="botao-entrar">Entrar</button>
    </fieldset>
  </form>
    <div class="box_link"><a href="esqueciMinhaSenha">Esqueci minha senha</a></div>
  
    <p class="dados-cadastro">
        
        <small>Não é cadastrado? 
            <a href="usuario" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Entre com seu login">Clique aqui</a>
        </small>
    </p>
   
</div>


