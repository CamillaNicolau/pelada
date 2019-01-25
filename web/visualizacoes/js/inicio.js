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
                            <p class="card-text"><b>Horário: </b>'+v.horario+'<br>\n\
                            <b>Quadra: </b>'+v.quadra+'<br><b>Endereço</b><br>\n\
                            '+v.rua+' - '+v.numero+', '+v.bairro+' - '+v.cidade+'<br>\n\
                            <button type="submit" class="btn btn-lg btn-success btn-default" id ="botao-cadastrar">Confirmar Presença</button><button type="button" class="btn btn-lg btn-danger btn-default" id="botao-cancelar">Cancelar</button></h4></div></div>');
                        } 
                    });
                } else{
                    $('#listaPelada').append('<div class="alert alert-warning" role="alert"><strong>Olá!</strong> Você não foi convocado para nenhuma pelada, clique <a href="pelada">aqui</a> para criar sua pelada ou encontre uma pertinho de você.</div>');
                }
            }
        }
    }); 
}
