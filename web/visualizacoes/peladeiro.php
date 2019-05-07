<div class=" container-content col h-100 flex-grow-1 mw-100 no-padding bg-secondary">
    <div class="box-header">
       <h2 class="box-title py-2 px-4 py-2 px-4 text-dark shadow"><strong>PELADEIRO</strong></h2>
    </div>
    <div id="cadastroPeladeiro" style="display: none">
        <form class="form-horizontal mx-auto d-block" action="peladeiro" method="post" name="form_cadastra_peladeiro" id="form_cadastra_peladeiro" >
            <div class="box-header">
                <h4 class="subtitle">Use os campos abaixo para cadastrar os peladeiros da sua pelada.</h4>
            </div>
            <br>
            <h3 class="box-title"><strong>INFORMAÇÕES DO PELADEIRO</strong></h3>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail" class="control-label">Email</label>
                            <input id="emailPeladeiro" name="emailPeladeiro" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="textTelefone" class="control-label">Telefone</label>
                            <input id="telPeladeiro" name="telPeladeiro" class="form-control" placeholder="(xx)xxxxx-xxxx" type="tel">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputPData" class="control-label">Data Nascimento</label>
                            <input type="date" name="dataNascimento" class="form-control" id="dataNascimento" required="" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="selectPosicao">Posição</label>
                            <select class="form-control" id="posicao" name="posicao">
                                <option value="" selected>Selecione</option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="selectTime">Time</label>
                            <select class="form-control" id="time" name="time">
                                <option value="" selected>Selecione</option> 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="radioParticipacao">Participação</label><br>
                        <input type="radio" name="participacao" id="mensalista" value="mensalista">Mensalista</label>
                        <input type="radio" name="participacao" id="diarista" value="diarista">Diarista</label>
                    </div>
                </div>
                <input name="id_peladeiro" value="" id="id_peladeiro" type="hidden" />
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
            </fieldset>
        </form>
    </div>
    <div id="peladeiro-listar" style="display: none"></div>
    <div class="table-responsive col-md-12 tabela-peladeiro" style="display: none">
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Email</th>
                  <th colspan="2" scope="col" style="text-align: center;">Ação</th>
                </tr>
            </thead>
            <tbody id="listaPeladeiro"></tbody>  
        </table>
    </div> 
    <span class="busca-peladeiro" style="display: none">
        <h2 class="box-title"><strong>ENCONTRE O PELADEIRO</strong></h2>
        <div class="alert alert-info" role="alert">
            <strong>Olá,</strong> informe um email para encontrar o peladeiro.
        </div>
        <input type="search" id="busca" name="busca">
        <button type="submit" id="encontra-peladeiro"><i class="fas fa-search"></i></button>
        <div class="table-responsive col-md-12 tabela-inserir-peladeiro" style="display: none">
            <table class="table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                      <th scope="col">Nome</th>
                      <th scope="col">E-mail</th>
                      <th scope="col">Adicionar</th>
                    </tr>
                </thead>
                <tbody id="peladeiro">
                    
                </tbody>     
            </table>
        </div>
        <br>
        <button id="cancelar-buscar" class="btn btn-danger btn-default">Cancelar</button>
    </span>
    <div class="botoes">
        <button type="button" class="btn btn-success btn-default" id ="botao-cadastrar">Cadastrar</button>
        <button type="button" class="btn btn-primary btn-default" id ="botao-busca-peladeiro">Encontrar peladeiro</button>
    </div>
</div>