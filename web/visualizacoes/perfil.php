<div id="perfil">
  <div class="profile-sidebar">
    <span>
      <div id="imagem-perfil"></div>
    </span>
    
    <div class="profile-usertitle">
      <div class="profile-usertitle-name">
        <div id="nomeUsuarioPerfil"></div>
      </div>
    </div>
    <div class="profile-userbuttons">
      <button type="button" class="btn btn-success btn-default" id ="botao-editar">Editar Perfil</button>
      <button type="button" class="btn btn-danger btn-default" id ="botao-desativar">Desativar</button>
    </div>
  </div>
</div>
</center>
<div id="conteudo">  
  <div id="usuario" style="display: none">
    <form class="form-horizontal mx-auto d-block" action="perfil" method="post" name="form_editar_usuario" id="form_editar_usuario" >
      <fieldset>
        <span>
      <div class="imagem-perfil"></div>
    </span>
        <label class="custom-file">
          <input type="file" id="imagemUsuario" name="imagemUsuario" class="custom-file-input">
          <span class="custom-file-control" placeholder="Browser">Selecione uma imagem</span>
        </label>
         <div class="form-group">
            <label for="textNome" class="control-label">Nome</label>
            <input id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Digite seu Nome" required="" type="text">
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
            <label for="radioSexo">Sexo</label>
            <input type="radio" name="sexo" id="feminino" value="f">Feminino</label>
            <input type="radio" name="sexo" id="masculino" value="m">Masculino</label>
          </div>
          <input name="acao" value="atualizar" id="acao_usuario" type="hidden" />
          <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
          <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
      </fieldset>
  </form>
</div>
</div>

