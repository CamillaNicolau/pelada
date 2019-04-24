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
                var Htmlvisualizacao;
                var atencao ;
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        if(v.visualizada == 0){

                            atencao = '<i class=" alert-warning fas fa-exclamation-circle"></i>';
                            Htmlvisualizacao = '<button onclick="vizualizarPelada('+v.notificacao+')" class="btn btn-danger btn-sm visualizacao" title=" Não visualizada"><i class="far fa-eye-slash"></i></button>';
                        
                            $('#listaNotificacao').append('<div class="card card-'+v.notificacao+'" style="width: 18rem;"><div class="card-body"><h6 class="card-subtitle mb-2 text-muted">'+atencao+' '+v.data+'</h6><p class="card-text">O peladeiro <b>'+v.nome+'</b>, solicita participar da pelada - <b>'+v.pelada+'</b>\n\
                          </p><p>'+Htmlvisualizacao+' <button class="btn btn-success btn-sm" onclick="cadastroPeladeiro()" id="adiciona-peladeiro-'+v.id+'" title="Adicionar peladeiro"><i class="fas fa-user-plus"></i></button> </p></div></div>');
                        } else{
                            $('#listaNotificacao').append('');
                        }
                        
                        if(v.status == 'encerrada'){
                            $('#adiciona-peladeiro-'+v.id).removeAttr("href").text('Pelada Encerrada').css('color','#b22222');
                        }
                    });
                } 
            }
        }
    }); 
}

function vizualizarPelada(id){
    $.ajax({
        type: 'POST',
        url: 'notificacao',
        data: 'acao=visualizacao&id_notificacao='+id+'&visualiza=1',
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Enviando solicitação...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                $(".card-"+id+"").hide(200);
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
                
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
            }
        }
    }); 
}

function cadastroPeladeiro() {
    window.open('pelada', '_self');
}