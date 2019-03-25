<div class="col-lg-10 h-100 flex-grow-1 mw-100 no-padding bg-secondary">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 text-dark shadow"><strong>MINHAS PELADAS</strong></h2>
        <h3 class="subtitle">Bem vindo(a), <?php echo $_SESSION['nome_usuario_logado'];?></h3>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="selectStatus">Status Pelada</label>
            <select class="form-control" id="status" name="status">
                <option value="" selected>Selecione Status</option>
                <option value="1" >AGUARDANDO</option>
                <option value="2" >CONFIRMADA</option>
                <option value="3" >CANCELADA</option>
                <option value="4" >ENCERRADA</option>
            </select>
        </div>
    <div id="listaPelada"></div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">Ausentes</h4><br>
                </div>
            </div>  
        </div>
    </div>
</div>
