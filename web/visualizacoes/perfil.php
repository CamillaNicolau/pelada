<div class=" container-content col flex-grow-1 mw-100 p-0 bg-secondary ">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 text-dark shadow"><strong>MEUS DADOS</strong></h2>
        <h4 class="subtitle">Use os campos abaixo para consultar e gerenciar suas informações pessoais.</h4>
    </div>
    <div class="main px-2">
        <div class="panel panel-default ">
            <div class="panel-body">
                <form class="form-horizontal mx-auto d-block col-md-6" action="perfil" method="post" name="form_editar_usuario" id="form_editar_usuario" >

                    <div class="form-group" style="text-align: center" >
                        <label>
                            <input type="file"name="imagemUsuario" class="custom-file-input ">
                            <div id="imagem-perfil" class="col-5 m-auto">  
                            </div>
                            <span class="custom-file-control" placeholder="Browser">Alterar</span>
                        </label>
                        </div>
                    <div class="form-group">
                        <label for="textNome" class="col-md-4 control-label">Nome</label>
                        <div class="col-md-12 ">
                            <input id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Digite seu Nome" required="" type="text">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="textApelido" class=" col-md-4 control-label">Apelido</label>
                        <div class="col-md-12">
                            <input id="apelidoUsuario" name="apelidoUsuario" class="form-control" placeholder="Digite seu Apelido" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class=" col-md-4 control-label">Email</label>
                        <div class="col-md-12">
                            <input id="emailUsuario" name="emailUsuario" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
                        </div>
                    </div>
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
                    <input name="acao" value="atualizar" id="acao_usuario" type="hidden" />
                    <span class="pb-5 col-md-6">
                        <button type="submit" class="btn btn-md btn-success m-s btn-default px-4" id ="botao-salvar">Salvar</button>
                    </span>
                </form>   
            </div>
        </div>
    </div>
</div>
