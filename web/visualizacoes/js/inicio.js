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
        success: function(retorno) {
            if (retorno.sucesso == true) {
                $('#listaPelada').html('');
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        if(v.id){
                          $('#listaPelada').append('<div class="card" style="width: 25rem;"><div class="card-header card-'+v.id+'"></div><div class="card-body"><h4 class="card-title">'+v.nome+' - '+v.data_pelada+'<p>\n\
                            <p class="card-text"><b>Horário: </b>'+v.horario+'<br>'+
                            '<b>Quadra: </b>'+v.quadra+'<br><b>Endereço</b><br>'+
                            ''+v.rua+' - '+v.numero+', '+v.bairro+' - '+v.cidade+'<br>'+
                            '<span class="botoes"><button type="submit" onclick="confirmarPelada('+v.id_peladeiro_pelada+',1)" class="btn btn-lg btn-success btn-default confirma-pelada-'+v.id_peladeiro_pelada+'" id="confirma-pelada">Confirmar Presença</button>'+
                            '<button type="button" onclick="confirmarPelada('+v.id_peladeiro_pelada+',2)" class="btn btn-lg btn-danger btn-default botao-cancelar-'+v.id_peladeiro_pelada+'" id="botao-cancelar">Cancelar</button></span></h4></div></div>');
                            if(v.confirmacao == 2 ){
                                $('.card-'+v.id).html('Pelada Cancelada').addClass('text-danger');
                                $('.confirma-pelada-'+v.id_peladeiro_pelada).hide();                               
                                $('.botao-cancelar-'+v.id_peladeiro_pelada).hide();
                            } else if(v.confirmacao == 1 ){
                                $('.card-'+v.id).html('Pelada Confirmada').addClass('text-success');
                                $('.confirma-pelada-'+v.id_peladeiro_pelada).hide();                               
                                $('.botao-cancelar-'+v.id_peladeiro_pelada).hide();
                            }  else if(v.status == "aguardando" && v.confirmacao == 0){
                                $('.card-'+v.id).html('Aguardando confirmação').addClass('text-warning');
                            } else if(v.status == "encerrada" && v.confirmacao == 0){
                                $('.card-'+v.id).html('Pelada Encerrada').addClass('text-danger');
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