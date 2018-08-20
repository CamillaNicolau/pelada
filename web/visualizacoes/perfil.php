<div id="perfil">
    <div class="panel panel-default">
        <div class="panel-heading">Perfil</div>
        <div class="panel-body">
            <form class="form-horizontal mx-auto d-block" action="perfil" method="post" name="form_editar_usuario" id="form_editar_usuario" >
                <div class="form-group" style="text-align: center">
                    <label>
                        <input type="file"name="imagemUsuario" class="custom-file-input">
                        <div id="imagem-perfil">  
                        </div>
                        <span class="custom-file-control" placeholder="Browser">Alterar</span>
                    </label>
		</div>
                <div class="form-group">
                    <label for="textNome" class="col-md-4 control-label">Nome</label>
                    <div class="col-md-6">
                        <input id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Digite seu Nome" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="textApelido" class=" col-md-4 control-label">Apelido</label>
                    <div class="col-md-6">
                        <input id="apelidoUsuario" name="apelidoUsuario" class="form-control" placeholder="Digite seu Apelido" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class=" col-md-4 control-label">Email</label>
                    <div class="col-md-6">
                        <input id="emailUsuario" name="emailUsuario" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-md-4 control-label">Senha</label>
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" id="password" required="" placeholder="Digite sua Senha">
                        <div class="progress">
                            <span id="progresso" class="progress-bar" role="progressbar" aria-valuemax="100"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="col-md-4 control-label">Confirme a senha</label>
                    <div class="col-md-6">
                        <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" required="" placeholder="Confirme a senha">
                    </div>
                </div>
            <input name="acao1" value="atualizar" id="acao_usuario" type="hidden" />
                    

            <button type="submit" class="btn btn-primary" id ="botao-salvar">Salvar</button>
            <button type="button" class="btn btn-danger btn-default" id ="botao-desativar">Desativar</button>
                </form>   
        </div>
    </div>
</div>
