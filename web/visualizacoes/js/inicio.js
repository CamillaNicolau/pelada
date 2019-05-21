$(document).ready(function() {  
    atualizarListaPelada();

    $('#status').change(function(){
        atualizarListaPelada($('#status').val());
    });
});

function atualizarListaPelada(status_pelada) {
    $.ajax({
        type: 'POST',
        url: 'inicio',
        data: 'acao=lista_pelada&status='+status_pelada,
        dataType: 'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Carregando...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso == true) {
                $('#listaPelada').html('');
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        if(v.id){
                          $('#listaPelada').append('<span class="col-md-6 col-xl-4">\n\
                                                        <div class="card card-'+v.id+' h-100">\n\
                                                            <div class="h5 card-header d-flex justify-content-between">\n\
                                                                <strong>'+v.nome+'</strong>\n\
                                                            </div>\n\
                                                            <div class="card-body">\n\
                                                                <h5 class="card-title card-title-'+v.id+'"><i class="far fa-calendar-alt mr-2"></i>'+v.data_pelada+'</h5>\n\
                                                                <h5>\n\
                                                                    <p class="card-text"><b>Horário: </b>'+v.horario+'<br>'+
                                                                    '<b>Quadra: </b>'+v.quadra+'<br>\n\
                                                                    <b>Endereço: </b>'+''+v.rua+' - '+v.numero+', '+v.bairro+' , '+v.cidade+' - '+v.sigla+' <br>'+
                                                                    '<span class="status-'+v.id+'"></span>\n\
                                                                    <span class="botoes">\n\
                                                                        <button type="submit" onclick="confirmarPelada('+v.id_peladeiro_pelada+',1)" class="btn btn-md mx-2 btn-success m-s btn-default confirma-pelada-'+v.id_peladeiro_pelada+'" id="confirma-pelada">Confirmar</button>'+
                                                                        '<button type="button" onclick="confirmarPelada('+v.id_peladeiro_pelada+',2)" class="btn btn-md mx-2 btn-danger btn-default botao-cancelar-'+v.id_peladeiro_pelada+'" id="botao-cancelar">Desistir</button>\n\
                                                                    </span>\n\
                                                                </h5>\n\
                                                            </div>\n\
                                                        </div>\n\
                                                    </span>');
                            if(v.confirmacao == 2 ){
                                $('.card-'+v.id).addClass('border-danger')
                                .find('.card-header').append('<i class=" alert-danger m-0 h4 fas fa-times-circle"></i> ').addClass('text-danger');
                                $('.status-'+v.id).append('<strong>Status: </strong>Cancelada');
                                $('.confirma-pelada-'+v.id_peladeiro_pelada).hide();
                                $('.botao-cancelar-'+v.id_peladeiro_pelada).hide();
                            } else if(v.confirmacao == 1 ){
                                $('.card-'+v.id).addClass('border-success')
                                .find('.card-header').append('<i class=" fas m-0 h4 fa-check-circle"></i> ').addClass('text-success');
                                $('.status-'+v.id).append('<strong>Status: </strong>Confirmada');
                                $('.confirma-pelada-'+v.id_peladeiro_pelada).hide();                               
                                $('.botao-cancelar-'+v.id_peladeiro_pelada).hide();
                            }  else if(v.status == "aguardando" && v.confirmacao == 0){
                                $('.card-'+v.id).addClass('border-warning')
                                .find('.card-header').append('<i class=" alert-warning m-0 h4 fas fa-exclamation-circle"></i> ').addClass('text-warning');
                                $('.status-'+v.id).append('<strong>Status: </strong>Aguardando confirmação <p>');
                            } else if(v.status == "encerrada" && v.confirmacao == 0){
                                $('.card-'+v.id).addClass('border-danger')
                                .find('.card-header').append('<i class=" alert-danger m-0 h4 fas fa-times-circle"></i> ').addClass('text-danger');
                                $('.status-'+v.id).append('<strong>Status: </strong>Encerrada');
                                $('.confirma-pelada-'+v.id_peladeiro_pelada).hide();                              
                                $('.botao-cancelar-'+v.id_peladeiro_pelada).hide();
                            } 
                        }
                    });
                } else {
                    if(status_pelada){
                        $('#listaPelada').append('<div class="alert alert-warning" role="alert"><strong>Olá!</strong> Você não possui nenhuma pelada com este status.</div>');
                    }else{
                        $('#listaPelada').append('<div class="alert alert-warning" role="alert"><strong>Olá!</strong> Você não foi convocado para nenhuma pelada, clique <a href="pelada">aqui</a> para criar sua pelada ou encontre uma pertinho de você.</div>');
                    }
                }
            }
        }
    }); 
}

function confirmarPelada(idPeladeiroPelada,confirmacao) {
    $.ajax({
        type: 'POST',
        url: 'inicio',
        data: 'acao=status_pelada_peladeiro&id_pelada_peladeiro='+idPeladeiroPelada+'&confirmacao='+confirmacao,
        dataType: 'json',
        success: function(retorno) {
            if (retorno.sucesso == true) {
                atualizarListaPelada()
                alertaFnc("Sucesso", retorno.mensagem,750, false, "success");
            }else{
                alertaFnc("Erro", retorno.mensagem, null, true, "error");
            }
        }
    }); 
}