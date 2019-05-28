<div class=" container-content col flex-grow-1 mw-100 p-0 bg-secondary ">
    <div class=" w-100 box-header mw-100">
        <h2 class="box-title py-2 col-12 text-dark shadow w-100"><strong>RELATÓRIOS</strong></h2>
    </div>
    <div class="px-2">
        <div class="col-md-6 col-xl-6 mb-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label for="status" class="input-group-text bg-primary text-light">Relatórios</label>
                </div>
                <select class="custom-select" id="relatorio" name="relatorio">
                    <option value="" selected>Selecione relatorio</option>
                    <option value="1" >Peladeiros Confirmados na pelada</option>
                    <option value="2" >Peladas ocorridas no mês</option>
                    <option value="3" >Peladas não confirmados </option>
                </select>
            </div>
        </div>
        <div class="table-responsive col-md-12 tabela-inserir-peladeiro" >
            <table class="table table-striped" cellspacing="0" cellpadding="0">

                <tbody id="listaRelatorio"></tbody>     
            </table>
        </div>
    </div>
</div>


