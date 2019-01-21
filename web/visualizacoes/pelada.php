<div id="conteudo">  
    <div id="cadastroPelada" style="display: none">
        <form class="form-horizontal mx-auto d-block" action="pelada" method="post" name="form_cadastro_pelada" id="form_cadastro_pelada" >
            <h2 class="box-title"><strong>MINHA PELADA</strong></h2>
            <h4 class="subtitle">Use os campos abaixo para cadastrar sua pelada.</h4>
            <fieldset>
                <div class="form-group">
                   <label for="textNome" class="control-label">Pelada:</label>
                   <input id="nomePelada" name="nomePelada" class="form-control" placeholder="Informe o nome da pelada" required="" type="text">
                </div>
                <div class="form-group">
                  <label for="textDescricao" class="control-label">Descrição</label>
                  <textarea id="descricaoPelada" name="descricaoPelada" class="form-control" rows="2" placeholder="Informações da pelada" type="text"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="textDuracao" class="control-label">Duração da partida:</label>
                            <input id="tempoJogo" name="tempoJogo" class="form-control" required="" type="time">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="textQtJogadores" class="control-label">Jogadores</label>
                          <input type="number" name="qtJogadores" class="form-control" id="qtJogadores" required="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputPData" class="control-label">Data partida</label>
                            <input type="date" name="dataPartida" class="form-control" id="dataPartida" required="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="inputPData" class="control-label">Horário partida</label>
                          <input type="time" name="horario" class="form-control" id="horario" required="" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label" for="radioSorteio">Sorteio</label>
                    <div class="col-md-4"> 
                        <label required="" class="radio-inline" for="radios-0" >
                            <input type="radio" name="sorteio" id="chegada" value="chegada" checked="checked">
                            Ordem de chegada
                        </label>
                        <label required="" class="radio-inline" for="radios-1" >
                            <input type="radio" name="sorteio" id="semSorteio" value="semSorteio">
                            Sem sorteio
                        </label>
                    </div>
                </div>
                <h2 class="box-title"><strong>INFORMAÇÕES DA QUADRA</strong></h2>
                <div class="form-group">
                    <label for="textLocalizacao" class="control-label">Nome da quadra</label>
                    <input id="nomeQuadra" name="nomeQuadra" class="form-control" required="" type="text">
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="textLocalizacao" class="control-label">Logradouro</label>
                            <input id="rua" name="rua" class="form-control" required="" type="text">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="textBairro" class="control-label">Bairro</label>
                            <input id="bairro" name="bairro" class="form-control" required="" type="text">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="textNumeor" class="control-label">Nº</label>
                            <input id="numero" name="numero" class="form-control" required="" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectEstado">Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="" selected>Selecione Estado</option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectCidade">Cidade</label>
                            <select class="form-control" id="cidade" name="cidade">
                                <option value="" selected>Selecione Cidade</option> 
                            </select>
                        </div>
                    </div>   
                </div>
                <input name="id_pelada" value="" id="id_pelada" type="hidden" />
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
            </fieldset>
        </form>
    </div>
    <div class="table-responsive col-md-12 tabela-pelada">
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora</th>
                  <th colspan="3" scope="col" style="text-align: center;">Ação</th>
                </tr>
            </thead>
            <tbody id="listaPelada">
                
            </tbody>     
        </table>
    </div>
    <span class="busca-pelada" style="display: none">
        <h2 class="box-title"><strong>ENCONTRE A SUA PELADA</strong></h2>
        <div class="alert alert-warning" role="alert">
            <strong>Olá!</strong> Aqui você encontra todas as peladas disponivéis de acordo com a cidade informada.
        </div>
        <input type="search" id="busca" name="busca" placeholder="Informe a cidade">
        <button type="submit" id="encontra-pelada"><i class="fas fa-search"></i></button>
        <div id="pelada">
            
        </div>
        <br>
        <button id="cancelar-buscar" class="btn btn-danger btn-default">Cancelar</button>
    </span>
    <form class="form-horizontal mx-auto d-block" action="pelada" method="post" name="form_adicionar_peladeiro" id="form_adicionar_peladeiro" >
        <span class="adicionar-peladeiro" style="display: none;">
            <h2 class="box-title"><strong>ADICIONE PELADEIRO</strong></h2>
            <div class="alert alert-warning" role="alert">
                <strong>Olá!</strong> Aqui você pode adicionar peladeiros a sua pelada.
            </div>
            <div id="adicionar-peladeiro"></div>
            <button type="submit" class="btn btn-success btn-default" name="acao" value="adicionar_peladeiro" id ="botao-adicionar">Adicionar</button>
            <button type="button" class="btn btn-danger btn-default" id ="cancelar-peladeiro">Cancela</button>
        </span>
    </form>
    <div class="botoes">
        <button type="button" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Cadastrar Pelada</button>
        <button type="button" class="btn btn-lg btn-primary btn-default" id ="botao-busca-pelada">Encontrar pelada</button>

    </div>
</div>

