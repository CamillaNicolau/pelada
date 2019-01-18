
  <div class="cabecalho_conteudo">
      <h2>Usuário</h2>
   </div>
    <form class="form-horizontal mx-auto d-block" action="usuario" method="post" name="form_cadastro_usuario" id="form_cadastro_usuario" >
      <fieldset>
        <label class="custom-file">
          <input type="file" id="imagemUsuario" name="imagemUsuario" class="custom-file-input">
          <span class="custom-file-control" placeholder="Browser">Selecione uma imagem</span>
        </label>
         <div class="form-group">
            <label for="textNome" class="control-label">Nome</label>
            <input id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Digite seu Nome" required="" type="text" title="Informe um nome">
          </div>
          <div class="form-group">
            <label for="textApelido" class="control-label">Apelido</label>
            <input id="apelidoUsuario" name="apelidoUsuario" class="form-control" placeholder="Digite seu Apelido" type="text">
          </div>
          <div class="form-group">
            <label for="inputEmail" class="control-label">Email</label>
            <input id="emailUsuario" name="emailUsuario" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
          </div>
          <div class="form-group">
            <label for="inputPData" class="control-label">Data Nascimento</label>
            <input type="date" name="dataNascimento" class="form-control" id="dataNascimento" required="" placeholder="">
          </div>
          <div class="form-group">
            <label for="selectTime">Time</label>
            <select class="form-control" id="time" name="time">
              <option value="" selected>Selecione</option> 
            </select>
          </div>
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
          <div class="form-group">
            <label for="radioSexo">Sexo</label>
            <input type="radio" name="sexo" value="feminino">Feminino</label>
            <input type="radio" name="sexo" value="masculino">Masculino</label>
          </div>
          <input name="acao" value="adicionar" id="acao_usuario" type="hidden" />
          <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Cadastrar</button>
          <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
      </fieldset>
  </form>

