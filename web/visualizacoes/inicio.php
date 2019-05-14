<div class=" container-content col flex-grow-1 mw-100 p-0 bg-secondary ">
    <div class=" w-100 box-header mw-100">
        <h2 class="box-title py-2 col-12 text-dark shadow w-100"><strong>MINHAS PELADAS</strong></h2>
    </div>
    <h3 class="subtitle col-12 my-4">Bem vindo(a), <?php echo $_SESSION['nome_usuario_logado'];?></h3>
    <div class="px-2">
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label for="status" class="input-group-text bg-primary text-light">Status Pelada</label>
                </div>
                <select class="custom-select" id="status" name="status">
                    <option value="" selected>Selecione Status</option>
                    <option value="1" >AGUARDANDO</option>
                    <option value="2" >CONFIRMADA</option>
                    <option value="3" >CANCELADA</option>
                    <option value="4" >ENCERRADA</option>
                </select>
            </div>
        </div>
        <div class="w-100">
            <div id="listaPelada" class="d-flex flex-row align-items-stretch"></div>
        </div>
    </div>
</div>
