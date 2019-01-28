$(document).ready(function() {  
    atualizarListaPelada();
});

function atualizarListaPelada() {
    $.ajax({
        type: 'POST',
        url: 'inicio',
        data: 'acao=lista_pelada',
        dataType: 'json',
        success: function(retorno) {
            if (retorno.sucesso == true) {
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        if(v.id){
                          $('#listaPelada').append('<div class="card" style="width: 25rem;"><div class="card-body"><h4 class="card-title">'+v.nome+' - '+v.data_pelada+'<p>\n\
                            <p class="card-text"><b>Horário: </b>'+v.horario+'<br>'+
                            '<b>Quadra: </b>'+v.quadra+'<br><b>Endereço</b><br>'+
                            +v.rua+' - '+v.numero+', '+v.bairro+' - '+v.cidade+'<br>'+
                            '<span class="botoes"><button type="submit" onclick="confirmarPelada('+v.id_peladeiro_pelada+',1)" class="btn btn-lg btn-success btn-default" id="confirma-pelada">Confirmar Presença</button>'+
                            '<button type="button" onclick="confirmarPelada('+v.id_peladeiro_pelada+',0)" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button></span></h4></div></div>');
                            if((v.data_pelada < v.data_atual)){
                                $('#confirma-pelada').prop("disabled", true);
                                $('#botao-cancelar').hide();
                            }
                            
                        }
                        
                    });
                } else{
                    $('#listaPelada').append('<div class="alert alert-warning" role="alert"><strong>Olá!</strong> Você não foi convocado para nenhuma pelada, clique <a href="pelada">aqui</a> para criar sua pelada ou encontre uma pertinho de você.</div>');
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
                alertaFnc("Sucesso", retorno.mensagem,750, false, "success");   
            }else{
                alertaFnc("Erro", retorno.mensagem, null, true, "error");
            }
        }
    }); 
}
   

