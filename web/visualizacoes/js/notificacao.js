$(document).ready(function() {  
    atualizarListaNotificacao();
});

function atualizarListaNotificacao() {
    $.ajax({
        type: 'POST',
        url: 'notificacao',
        data: 'acao=lista_notificacao',
        dataType: 'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Carregando...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso == true) {
                $('#listaNotificacao').html('');
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        
                        $('#listaNotificacao').append('<div class="card" style="width: 18rem;"><div class="card-body"><h6 class="card-subtitle mb-2 text-muted">'+v.data+'</h6><p class="card-text">O peladeiro <b>'+v.nome+'</b>, solicita participar da pelada - <b>'+v.pelada+'</b>\n\
                          </p><p><a href="pelada" class="card-link" id="adiciona-peladeiro-'+v.id+'">Adicionar peladeiro</a></p></div></div>');
                        if(v.status == 'encerrada'){
                            $('#adiciona-peladeiro-'+v.id).removeAttr("href").text('Pelada Encerrada').css('color','#b22222');
                        }
                    });
                } 
            }
        }
    }); 
}

