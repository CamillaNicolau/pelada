<div class=" container-content col flex-grow-1 mw-100 p-0 bg-secondary ">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 py-2 px-4 text-dark shadow"><strong>MINHA PELADA</strong></h2>
    </div>
    <div class="main px-2">
    <div id="pelada-exibir" style="display: none"></div>
    <div id="cadastroPelada" style="display: none">
        <form class="form-horizontal mx-auto d-block col-md-12" action="pelada" method="post" name="form_cadastro_pelada" id="form_cadastro_pelada" >
            <div class="box-header">
                <h4 class="subtitle">Use os campos abaixo para cadastrar sua pelada.</h4>
            </div>
            <fieldset >
                <div class="form-group">
                   <label for="textNome" class="control-label">Pelada*</label>
                   <input id="nomePelada" name="nomePelada" class="form-control" placeholder="Informe o nome da pelada" required="" type="text">
                </div>
                <div class="form-group">
                  <label for="textDescricao" class="control-label">Descrição</label>
                  <textarea id="descricaoPelada" name="descricaoPelada" class="form-control" rows="2" placeholder="Informações da pelada" type="text"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="textDuracao" class="control-label">Duração da partida*</label>
                            <input id="tempoJogo" name="tempoJogo" class="form-control" required="" type="time">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="textQtJogadores" class="control-label">Jogadores*</label>
                          <input type="number" name="qtJogadores" class="form-control" id="qtJogadores" required="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputPData" class="control-label">Data partida*</label>
                            <input type="date" name="dataPartida" class="form-control" id="dataPartida" required="" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="inputPData" class="control-label">Horário partida*</label>
                          <input type="time" name="horario" class="form-control" id="horario" required="" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12 col-lg-6 d-flex flex-column">
                    <label for="radioSorteio">Sorteio</label>
                    <div class="btn-group" data-toggle="buttons"> 
                        <label class="btn btn-secondary w-50" >
                            <input type="radio" name="sorteio" id="chegada" value="chegada" checked="checked">
                            Ordem de chegada
                        </label>
                        <label class="btn btn-secondary w-50">
                            <input type="radio" name="sorteio" id="semSorteio" value="semSorteio">
                            Sem sorteio
                        </label>
                    </div>
                </div>
                <h2 class="box-subtitle"><strong>INFORMAÇÕES DA QUADRA</strong></h2>
                <div class="form-group">
                    <label for="textLocalizacao" class="control-label">Nome da quadra*</label>
                    <input id="nomeQuadra" name="nomeQuadra" class="form-control" required="" type="text">
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="textLocalizacao" class="control-label">Logradouro*</label>
                            <input id="rua" name="rua" class="form-control" required="" type="text">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="textBairro" class="control-label">Bairro*</label>
                            <input id="bairro" name="bairro" class="form-control" required="" type="text">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="textNumeor" class="control-label">Nº*</label>
                            <input id="numero" name="numero" class="form-control" required="" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectEstado">Estado*</label>
                            <select class="custom-select" id="estado" name="estado" required="">
                                <option value="" selected>Selecione Estado</option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="selectCidade">Cidade*</label>
                            <select class="custom-select" id="cidade" name="cidade" required="">
                            </select>
                        </div>
                    </div>   
                </div>
                <input name="id_pelada" value="" id="id_pelada" type="hidden" />
                <input name="id_localizacao" value="" id="id_localizacao" type="hidden" />
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <span class="pb-5">
                    <button type="submit" class="btn btn-md mx-2 btn-success m-s btn-default px-4" id ="botao-salvar">Salvar</button>
                    <button type="button" class="btn btn-md mx-2 btn-danger btn-default px-4" id="botao-cancelar">Cancelar</button>
                </span>
            </fieldset>
        </form>
    </div>
    <div id="pelada-exibir" style="display: none"></div>
    <div class="table-responsive col-md-12 tabela-pelada" style="display: none">
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Data</th>
                  <th scope="col">Hora</th>
                  <th colspan="4" scope="col" style="text-align: center;">Ação</th>
                </tr>
            </thead>
            <tbody id="listaPelada">
                
            </tbody>     
        </table>
    </div>
    <div class="busca-pelada col-12" style="display: none">
        <h2 class="box-subtitle"><strong>Encontre a sua pelada</strong></h2>
        <div class="alert alert-info" role="alert">
            <strong>Olá!</strong> Aqui você encontra todas as peladas disponivéis de acordo com a cidade informada.
        </div>
        <div class="input-group col-12 col-md-6 p-0 mb-3">
            <input class="form-control" type="search" id="busca" name="busca" placeholder="Informe a cidade">
            <button class="btn btn-info col-3 col-md-2 p-0" type="submit" id="encontra-pelada"><i class="fas fa-search"></i></button>
        </div>
        <div class="w-100">
            <div id="pelada" class="d-flex flex-row align-items-stretch"></div>
        </div>
        <button id="cancelar-buscar" class="btn btn-danger btn-default">Cancelar</button> 
    </div>
    <form class="form-horizontal mx-auto d-block" action="pelada" method="post" name="form_adicionar_peladeiro" id="form_adicionar_peladeiro" >
        <span class="adicionar-peladeiro" style="display: none;">
            <h2 class="box-subtitle"><strong>ADICIONE PELADEIRO</strong></h2>
            <div class="alert alert-info" role="alert">
                <strong>Olá!</strong> Aqui você pode adicionar peladeiros a sua pelada.
            </div>
            <div class="table-responsive col-md-12 tabela-adiciona-peladeiro">
                <table class="table table-striped" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                          <th scope="col">Nome</th>
                          <th scope="col">E-mail</th>
                          <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="adicionar-peladeiro">
                        
                    </tbody>     
                </table>
            </div>
            <div id="dados-peladeiro"></div>
            <div id="id-pelada"></div>
            <button type="submit" class="btn btn-success btn-default" name="acao" value="adicionar_peladeiro" id ="botao-adicionar">Adicionar</button>
            <button type="button" class="btn btn-danger btn-default" id ="cancelar-peladeiro">Cancelar</button>
        </span>
        <div id="peladeiro-exibir" style="display: none">
        </div>
    </form>
   

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" id="modal-pelada">
            </div>
        </div>
    </div>

    <div class="botoes pb-5 ">
        <button type="button" class="btn btn-md mx-2 btn-success m-s btn-default px-4" id ="botao-cadastrar">Cadastrar Pelada</button>
        <button type="button" class="btn btn-md mx-2 btn-info btn-default px-4" id ="botao-busca-pelada">Encontrar pelada</button>

    </div>
</div>
</div>

