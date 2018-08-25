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
                $.each(retorno.html,function(i,v){
                  $('#listaPelada').append('<p>Você foi convocado para a pelada do dia <b>'+v.data_pelada+'</b>.</p>\
                    <b>Nome: </b>'+v.nome_pelada+'<br>\n\
                    <b>Observações: </b>'+v.observacoes+'<br>\n\
                    <b>Horário: </b>'+v.horario+'<br>\n\
                    <b>Local: </b>'+v.nome_quadra+', '+v.numero+' - '+v.bairro+', '+v.cidade+'<br></p>\n\
                    <button onclick="confirmados('+v.id+')" class="btn btn-primary btn-xs">Confirmados</button>');
                });
            }
        }
    }); 
}
