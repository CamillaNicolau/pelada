
<div id="conteudo"> 
    <div class="cabecalho_conteudo">
      <h2>Peladeiro</h2>
    </div>
    <div id="cadastroPeladeiro" style="display: none">
        <form class="form-horizontal mx-auto d-block" action="peladeiro" method="post" name="form_cadastra_peladeiro" id="form_cadastra_peladeiro" >
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
                    <input id="nomePeladeiro" name="nomePeladeiro" class="form-control" placeholder="Digite seu Nome" required="" type="text">
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="control-label">Email</label>
                    <input id="emailPeladeiro" name="emailPeladeiro" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
                </div>
                <div class="form-group">
                    <label for="textTelefone" class="control-label">Telefone</label>
                    <input id="telPeladeiro" name="telPeladeiro" class="form-control" placeholder="(xx)xxxxx-xxxx" type="tel">
                </div>
                <div class="form-group">
                    <label for="inputPData" class="control-label">Data Nascimento</label>
                    <input type="date" name="dataNascimento" class="form-control" id="dataNascimento" required="" placeholder="">
                </div>
                <div class="form-group">
                    <label for="selectPosicao">Posição</label>
                    <select class="form-control" id="posicao" name="posicao">
                        <option value="" selected>Selecione</option> 
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectTime">Time</label>
                    <select class="form-control" id="time" name="time">
                        <option value="" selected>Selecione</option> 
                    </select>
                </div>
                <div class="form-group">
                  <label for="radioParticipacao">Participação</label>
                  <input type="radio" name="participacao" id="mensalista" value="mensalista">Mensalista</label>
                  <input type="radio" name="participacao" id="diarista" value="diarista">Diarista</label>
                </div>
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
            </fieldset>
        </form>
    </div>
    <table id="listaPeladeiro"></table>
    <div class="botoes">
        <button type="button" class="btn btn-success btn-default" id ="botao-cadastrar">Cadastrar</button>
        <button type="button" class="btn btn-primary btn-default" id ="botao-busca-peladeiro">Encontrar peladeiro</button>
    </div>
</div>