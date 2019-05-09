<div class="border rounded shadow-lg">
  <div class="cabecalho_conteudo text-center bg-secondary px-3 py-2 rounded-top border-bottom">
      <h5 class="mb-0 te">Cadastro de usuário</h5>
   </div>
    <form class="form-horizontal mx-auto d-block py-3 col-12 bg-light" action="usuario" method="post" name="form_cadastro_usuario" id="form_cadastro_usuario" >
      <fieldset>
        <div class="form-row">
          <div class="form-group col-sm-12 col-lg-6">
            <label for="textNome" class="control-label">Nome</label>
            <input id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Digite seu Nome" required="" type="text" title="Informe um nome">
          </div>
          <div class="form-group col-sm-12 col-lg-6">
            <label for="textApelido" class="control-label">Apelido</label>
            <input id="apelidoUsuario" name="apelidoUsuario" class="form-control" placeholder="Digite seu Apelido" type="text">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-12 col-lg-6">
            <label for="inputEmail" class="control-label">Email</label>
            <input id="emailUsuario" name="emailUsuario" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
          </div>
          <div class="form-group col-sm-12 col-lg-6 d-flex align-items-end">
            <span class="custom-file col-12">
              <input type="file" id="imagemUsuario" name="imagemUsuario" class="custom-file-input">
              <label class="custom-file-label" for="customFile">Selecione uma foto</label>
            </span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-12 col-lg-6 ">
            <label for="inputPData" class="control-label">Data Nascimento</label>
            <input type="date" name="dataNascimento" class="form-control" id="dataNascimento" required="" placeholder="">
          </div>
          <div class="form-group col-sm-12 col-lg-6 d-flex flex-column">
            <label for="radioSexo">Sexo</label>
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-secondary w-50">
                <input type="radio" id="feminino" value="feminino" name="sexo"> Feminino
              </label>
              <label class="btn btn-secondary w-50">
                <input type="radio" id="masculino" value="masculino" name="sexo"> Masculino
              </label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-sm-12 col-lg-6 ">
            <label for="inputPassword" class="control-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required="" placeholder="Digite sua Senha">
            <div class="progress">
            <span id="progresso" class="progress-bar" role="progressbar" aria-valuemax="100"></span>
            </div>
          </div>
          <div class="form-group col-sm-12 col-lg-6">
            <label for="inputPassword" class="control-label">Confirme a senha</label>
            <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" required="" placeholder="Confirme a senha">
          </div>
        </div>

        <input name="acao" value="adicionar" id="acao_usuario" type="hidden" />
        <button type="submit" class="btn btn-m btn-success btn-default align-self-end" id ="botao-cadastrar">Cadastrar</button>
        <button type="button" class="btn btn-m btn-danger btn-default align-self-end" id="botao-cancelar">Cancelar</button>
      </div>
    </fieldset>
  </form>

  </div>