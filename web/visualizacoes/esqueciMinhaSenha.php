 <form class="form-horizontal mx-auto d-block" action="esqueciMinhaSenha" method="post" name="form_esqueci_senha" id="form_esqueci_senha" >
    <p>
      Esqueceu a senha?!<br />Informe seu e-mail que enviaremos uma nova.<br />Em caso de dúvidas
      entre em contato com o adminstrador do sistema.
    </p>
    <div class="form-group">
        <label for="inputEmail" class="control-label">Email</label>
        <input id="email" name="email" class="form-control" placeholder="Digite seu E-mail" type="email">
     </div>
    <input name="acao" value="recuperar_senha" id="acao_recuperar_senha" type="hidden" />
    <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-enviar">Enviar</button>
</form>

