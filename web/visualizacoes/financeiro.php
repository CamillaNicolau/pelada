<div class="col-lg-10 box h-100 pl-4">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 text-light"><strong>FINANCEIRO</strong></h2>
    </div>
    <div id="lancamentoPelada" style="display: none">
	    <form class="form-horizontal mx-auto d-block" action="financeiro" method="post" name="form_lancamento" id="form_lancamento">
	       	<div class="box-header">
                <h4 class="subtitle">Use os campos abaixo para cadastrar seus lançamentos.</h4>
            </div>
        	<div class="form-group">
                <label for="selectPelada">Pelada</label>
                <select class="form-control" id="pelada" name="pelada">
                    <option value="" selected>Selecione a pelada</option> 
                </select>
            </div>
            <div class="form-group ">
                <label for="texValorTotal" class="control-label">Valor pelada</label>
                <input id="valorTotal" name="valorTotal" class="form-control dinheiro"  required="" type="text">
            </div>
            <div class="form-group">
                <label for="texValorDiaria" class="control-label">Valor por diárista</label>
                <input id="valorDiaria" name="valorDiaria" class="form-control dinheiro"  required="" type="text">
            </div>
            <div class="form-group">
                <label for="texValorMensalista" class="control-label">Valor por mensalista</label>
                <input id="valorMensalista" name="valorMensalista" class="form-control dinheiro"  required="" type="text">
            </div>
            <input name="id_lancamento" value="" id="id_lancamento" type="hidden" />
            <input name="acao" value="adicionar" id="acao" type="hidden" />
	         <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-salvar">Salvar</button>
                <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button>
	    </form>
	</div>
	<div id="lancamento-exibir" style="display: none">
    </div>
    <div class="table-responsive col-md-12 tabela-lancamento" style="display: none">
        <table class="table table-striped" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <th scope="col">Pelada</th>
                  <th scope="col">Valor total</th>
                  <th colspan="4" scope="col" style="text-align: center;">Ação</th>
                </tr>
            </thead>
            <tbody id="listaLancamento">
                
            </tbody>     
        </table>
    </div>
    <span class="busca-peladeiro-pagamento" style="display: none">
        <div class="table-responsive col-md-12 tabela-status-pagamento">
            <table class="table table-striped" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                      <th scope="col">Nome</th>
                      <th scope="col">Info Pagamento</th>
                    </tr>
                </thead>
                <tbody id="peladeiro-pagamento">
                    
                </tbody>     
            </table>
        </div>
        <button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar-lancamento">Cancelar</button>
    </span>
    <div class="botoes">
        <button type="button" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Cadastrar Lançamento</button>
    </div>
</div>