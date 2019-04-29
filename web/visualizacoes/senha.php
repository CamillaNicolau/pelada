<div class=" container-content col h-100 flex-grow-1 mw-100 no-padding bg-secondary">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 text-dark shadow"><strong>Cadastrar Senha</strong></h2>
    </div>
    <form class="form-horizontal mx-auto d-block col-md-6" action="senha" method="post" name="form_cadastra_senha" id="form_cadastra_senha" >
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
            <label for="inputPassword" class="col-md-6 control-label">Confirme a senha</label>
            <div class="col-md-12">
                <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Confirme a senha">
            </div>
        </div>
        <input name="acao" value="cadastra_senha" id="acao_usuario" type="hidden" />
          <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Cadastrar</button>
    </form>
    
</div>