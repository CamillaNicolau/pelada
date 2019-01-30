<div class="col-lg-10 box h-100 pl-4">
    <div class="box-header">
        <h2 class="box-title py-2 px-4 text-light">MINHAS PELADAS</h2>
        <h3 class="subtitle">Bem vindo(a), <?php echo $_SESSION['nome_usuario_logado'];?></h3>
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
