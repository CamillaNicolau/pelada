<div class=" container-content col flex-grow-1 mw-100 p-0 bg-secondary ">
    <div class="box-header">
       <h2 class="box-title py-2 px-4 py-2 px-4 text-dark shadow"><strong>PELADEIRO</strong></h2>
    </div>
    <div id="cadastroPeladeiro" style="display: none">
        <form class="form-horizontal mx-auto d-block col-md-12" action="peladeiro" method="post" name="form_cadastra_peladeiro" id="form_cadastra_peladeiro" >
            <div class="box-header">
                <h4 class="subtitle">Use os campos abaixo para cadastrar os peladeiros da sua pelada.</h4>
            </div>
            <br>
            <h3 class="box-title"><strong>INFORMAÇÕES DO PELADEIRO</strong></h3>
            <fieldset>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-lg-6 d-flex align-items-end">
                        <span class="custom-file col-12">
                          <input type="file" id="imagemUsuario" name="imagemUsuario" class="custom-file-input">
                          <label class="custom-file-label" for="customFile">Selecione uma foto</label>
                        </span>
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="textNome" class="control-label">Nome</label>
                        <input id="nomePeladeiro" name="nomePeladeiro" class="form-control" placeholder="Digite seu Nome" required="" type="text">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="inputEmail" class="control-label">Email</label>
                        <input id="emailPeladeiro" name="emailPeladeiro" class="form-control" placeholder="Digite seu E-mail" required="" type="email">
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="textTelefone" class="control-label">Telefone</label>
                        <input id="telPeladeiro" name="telPeladeiro" class="form-control" placeholder="(xx)xxxxx-xxxx" type="tel">
                    </div>   
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="inputPData" class="control-label">Data Nascimento</label>
                        <input type="date" name="dataNascimento" class="form-control" id="dataNascimento" required="" placeholder="">
                    </div>
                    <div class="form-group col-sm-12 col-lg-6 d-flex flex-column">
                        <label for="radioParticipacao">Participação</label>
                        <div class="btn-group" data-toggle="buttons"> 
                            <label class="btn btn-secondary w-50" >
                                <input type="radio" name="participacao" id="mensalista" value="mensalista">Mensalista
                            </label>
                            <label class="btn btn-secondary w-50" >
                                <input type="radio" name="participacao" id="diarista" value="diarista">Diarista
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="selectPosicao">Posição</label>
                        <select class="custom-select" id="posicao" name="posicao">
                            <option value="" selected>Selecione</option> 
                        </select>
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="selectTime">Time</label>
                        <select class="custom-select" id="time" name="time">
                            <option value="" selected>Selecione</option> 
                        </select>
                    </div>
                </div>
                <input name="id_peladeiro" value="" id="id_peladeiro" type="hidden" />
                <input name="acao" value="adicionar" id="acao" type="hidden" />
                <span class="pb-5">
                    <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                    <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
                </span>
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
<<<<<<< .mine
    <span class="busca-peladeiro col-md-12" style="display: none">
        <h2 class="box-title"><strong>ENCONTRE O PELADEIRO</strong></h2>
        <div class="alert alert-info" role="alert">
=======
    <span class="busca-peladeiro col-md-12" style="display: none">
        <h2 class="box-title py-2 px-4 py-2 px-4 text-dark shadow"><strong>ENCONTRE O PELADEIRO</strong></h2>
        <div class="alert alert-info col-md-12" role="alert">
>>>>>>> .r125
            <strong>Olá,</strong> informe um email para encontrar o peladeiro.
        </div>
        <div class="form-group col-sm-12 col-lg-4 d-flex align-items-end">
            <input id="busca" name="busca" class="form-control" required="" type="search">
            <button type="submit" id="encontra-peladeiro" class="btn "><i class="fas fa-search"></i></button>
        </div>
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
        <button id="cancelar-buscar" class="btn btn-md mx-2 btn-danger btn-default px-4">Cancelar</button>
    </span>
    <div class="botoes pb-5 ">
        <button type="button" class="btn btn-md mx-2 btn-success m-s btn-default px-4" id ="botao-cadastrar">Cadastrar</button>
        <button type="button" class="btn btn-md mx-2 btn-info btn-default px-4" id ="botao-busca-peladeiro">Encontrar peladeiro</button>
    </div>
</div>