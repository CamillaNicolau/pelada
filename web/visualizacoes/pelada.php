<div id="conteudo">  
   <div class="cabecalho_conteudo">
      <h2>Pelada</h2>
   </div>
    <div id="cadastroPelada" style="display: none">
        <form class="form-horizontal mx-auto d-block" action="pelada" method="post" name="form_cadastro_pelada" id="form_cadastro_pelada" >
          <fieldset>
                <div class="form-group">
                   <label for="textNome" class="control-label">Nome</label>
                   <input id="nomePelada" name="nomePelada" class="form-control" placeholder="Informe o nome da pelada" required="" type="text">
                </div>
                <div class="form-group">
                  <label for="textDescricao" class="control-label">Descrição</label>
                  <textarea id="descricaoPelada" name="descricaoPelada" class="form-control" rows="3" placeholder="" type="text"></textarea>
                </div>
              <div class="form-group">
                    <label for="textLocalizacao" class="control-label">Localização</label>
                    <input id="localizacao" name="localizacao" class="form-control" required="" type="text">
                </div>
                 <div class="form-group">
                    <label for="textDuracao" class="control-label">Duração da partida:</label>
                    <input id="tempoJogo" name="tempoJogo" class="form-control" required="" type="time">
                </div>
                <div class="form-group">
                  <label for="textQtJogadores" class="control-label">Jogadores</label>
                  <input type="number" name="qtJogadores" class="form-control" id="qtJogadores" required="" placeholder="Informe a quantidade maxima de jogadores">
                </div>
                <div class="form-group">
                  <label for="radioSorteio">Sorteio</label>
                  <input type="radio" name="sorteio" id="chegada" value="chegada">Ordem de chegada</label>
                  <input type="radio" name="sorteio" id="semSorteio" value="semSorteio">Sem sorteio</label>
                </div>
                <div class="form-group">
                  <label for="inputPData" class="control-label">Data</label>
                  <input type="date" name="dataPartida" class="form-control" id="dataPartida" required="" placeholder="">
                </div>
                <input name="id_pelada" value="" id="id_pelada" type="hidden" />
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
            </fieldset>
        </form>
    </div>
    <div class="table-responsive col-md-12">
        <table class="table table-striped" cellspacing="0" cellpadding="0" id="listaPelada">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th class="actions">Ações</th>
                 </tr>
            </thead>
            <tbody>
 
                <tr>
                    <td>Pelada 1</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing Lorem ipsum dolor sit amet, consectetur adipiscingJes</td>
                    <td>01/10/2018</td>
                    <td class="actions">
                        <a class="btn btn-primary btn-xs" href="edit.html">Editar</a>
                        <a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" data-target="#delete-modal">Excluir</a>
                    </td>
                </tr>
                <tr>
                    <td>Pelada 2</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing</td>
                    <td>01/01/2018</td>
                    <td class="actions">
                        <a class="btn btn-primary btn-xs" href="edit.html">Editar</a>
                        <a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" data-target="#delete-modal">Excluir</a>
                    </td>
                </tr>
                <tr>
                    <td>Pelada 3</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing</td>
                    <td>01/08/2018</td>
                    <td class="actions">
                        <a class="btn btn-primary btn-xs" href="edit.html">Editar</a>
                        <a class="btn btn-danger btn-xs"  href="#" data-toggle="modal" data-target="#delete-modal">Excluir</a>
                    </td>
                </tr>
 
            </tbody>
        </table>
    </div>
    <div class="botoes">
      <button type="button" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Cadastrar Pelada</button>
    </div>
</div>

