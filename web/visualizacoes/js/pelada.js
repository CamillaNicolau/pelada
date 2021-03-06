$(document).ready(function() {
          atualizarListaPelada();
    $("#botao-cadastrar").bind('click',function(){
        $('#cadastroPelada').slideDown();
        $(".botoes").hide();
        $('#pelada-exibir').hide();
        $('.tabela-pelada').hide();
        
    });
    $('#botao-cancelar').bind('click',resetarFormulario);
    

    $("#botao-busca-pelada").bind('click',function(){
        $('.busca-pelada').slideDown();
        $(".botoes").hide();
        $(".tabela-pelada").hide();
    });

    $("#encontra-pelada").bind('click',function(){
        $('#pelada-exibir').hide();
      encontrarPelada();
    });
    $("#cancelar-buscar").bind('click',function(){
      resetarFormulario();
    });
    $("#cancelar-peladeiro").bind('click',function(){
      resetarFormulario();
    });
    montarEstado();
    $('#estado').change(function(){
        montarCidade();
    });
    if($('#estado').val() != "" || $('#estado').val() != null){

        montarCidade();
    } 

    montarCidade();
    $('#form_cadastro_pelada').ajaxForm({ 
      dataType:  'json',
      beforeSend: validaForm,
      success:   tratarResultado 
    });
    $('#form_adicionar_peladeiro').ajaxForm({ 
      dataType:  'json',
      beforeSend: validaFormPeladeiro,
      success:   tratarResultadoPeladeiro 
    });
    
   

});

function validaForm(){
    if(true){
        
        alertaFnc("Aguarde", "Salvando dados...", null, true, null);
        return true;
    } else {
        return false;
    }
}

function tratarResultado (retorno) {  
    if(retorno.sucesso == true)
    {
      resetarFormulario();
      atualizarListaPelada();
      alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
    } else {
      alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
    }
}

function validaFormPeladeiro(){
    if(true){
        alertaFnc("Aguarde", "Salvando dados...", null, true, null);
        return true;
    } else {
        return false;
    }
}

function tratarResultadoPeladeiro (retorno) {  
    if(retorno.sucesso == true)
    {
        resetarFormulario();
        atualizarListaPelada();
      alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
    } else {
      alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
    }
}

function atualizarListaPelada() {
    $.ajax({
        type: 'POST',
        url: 'pelada',
        data: 'acao=lista_pelada',
        dataType: 'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Carregando...", 150, false, null);
        },
        success: function(retorno) {
            $('#listaPelada').html('');
            $('#pelada-exibir').html('');
            if (retorno.sucesso == true) {
                if((retorno.html).length > 0){
                    $('.tabela-pelada').show();
                    $.each(retorno.html,function(i,v){
                      $('#listaPelada').append('<tr><td class="col-md-2">'+v.nome+'</td><td class="col-md-2">'+v.data_partida+'</td>'+
                        '<td class="col-md-2">'+v.horario+'</td>'+
                        '<td><button onclick="buscarPeladeiro('+v.idPelada+')" title="adicionar peladeiro" class="btn btn-info btn-xs adiciona-peladeiro-'+v.idPelada+'" id="adiciona-peladeiro"><i class="fas fa-user-plus"></i></button></td>'+
                        '<td><button onclick="editarPelada('+v.idPelada+','+v.idLocalizacao+')" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></button></td>'+
                        '<td><button onclick="removerPelada('+v.idPelada+')" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></ button></td>'+
                        '<td><button onclick="infoPelada('+v.idPelada+')" title="Informa????es da pelada" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal"><i class="fas fa-info-circle"></i></ button></td>'+
                        '</tr></tbody>');
                        if(v.status == 'encerrada'){
                            $('.adiciona-peladeiro-'+v.idPelada).prop('disabled',true);
                        }
                    });
                } else{

                    $('#pelada-exibir').show();
                    $('#pelada-exibir').append('<div class="alert alert-warning" role="alert"><strong>Ol??!</strong> Voc?? n??o possui nenhuma pelada</div>');
                }
            }
        }
    }); 
}

function buscarPeladeiro(id_pelada){
    
    $(".botoes").hide();
    $(".tabela-pelada").hide();
   
    $.ajax({
        type: 'POST',
        url: 'pelada',
        data: 'acao=buscar_peladeiro&id_pelada='+id_pelada,
        dataType: 'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Carregando...", 250, false, null);
        },
        success: function(retorno) {
            $('#adicionar-peladeiro').html('');
            $('#id-pelada').html('');
            if (retorno.sucesso == true) {
                var disable;
                var checar;
                if((retorno.html).length > 0){
                    $('.adicionar-peladeiro').show();
                    $.each(retorno.html,function(i,v){
                        if(v.idCad){
                            disable = 'disabled="disable"';
                            checar = 'checked="checked"';
                        }else{
                            disable = "";
                            checar = "";
                        }

                        $('#adicionar-peladeiro').append('<tr><td class="col-md-2"><input type="checkbox" aria-label="Chebox para permitir input text" name="peladeiro[]" value="'+v.id+'" '+disable+' '+checar+'>  '+v.nome+'</td>'+
                            '<td class="col-md-2">'+v.email+'</td>'+
                            '<td><button onclick="removerPeladeiroPelada('+v.id+','+retorno.id_pelada+')" class="btn btn-danger btn-xs"> <i class="fas fa-trash"></i></ button></td>'+
                            '</tr></tbody>');
                        $('input[type=checkbox]').on('change', function () {
                            var total = $('input[type=checkbox]:checked').length;
                            if(total == v.qt_jogadores){  
                                alertaFnc("Aten????o", 'Voc?? atingiu o n??mero m??ximo de peladeiros determinado na pelada', null, true, "warning");
                            }
                            if(total > v.qt_jogadores){
                                alertaFnc("Opa", 'Voce ultrapassou o limite de peladeiros.<br>Remova ou desmarque peladeiros', null, true, "error");
                                $('#botao-adicionar').attr('disabled',true);
                            } else {
                                $('#botao-adicionar').attr('disabled',false);

                            }
                        });
                    });
                    $('#id-pelada').append('<input name="pelada" value="'+retorno.id_pelada+'" id="pelada" type="hidden" />');
                } else{
                    $('#peladeiro-exibir').show();
                    $('#peladeiro-exibir').append('<div class="alert alert-warning" role="alert"><strong>Ol??!</strong> Voc?? n??o possui nenhuma peladeiro cadastrado! Para cadastrar clique <a href="peladeiro">aqui</a> .</div>');   
                }
            }
        }
    }); 
}

function resetarFormulario(){
    $("#form_cadastro_pelada")[0].reset();
    $("#cadastroPelada").slideUp(function() {
       atualizarListaPelada();
    }); 
    $('.busca-pelada').hide();
    $('.adicionar-peladeiro').hide();
    $(".botoes").show();
    
}

function encontrarPelada() {
    
    var cidade  = $('#busca').val();
    $.ajax({
        type: 'POST',
        url: 'pelada',
        data: 'acao=buscar_pelada&cidade='+cidade,
        dataType: 'json',
        beforeSend: function() {

        }, 
        success: function(retorno) {
            $('#pelada').html('');
            if (retorno.sucesso == true) {
                $.each(retorno.html,function(i,v){
                  $('#pelada').append(
                        '<span class="col-md-6 col-xl-4">'+
                            '<div class="card card-'+v.id+' h-100">'+
                                '<div class="h5 card-header d-flex justify-content-between">'+
                                    '<strong>'+v.nome+'</strong>'+
                                '</div>'+
                                '<div class="card-body">'+
                                    '<h5 class="card-title card-title-'+v.id+'"><i class="far fa-calendar-alt mr-2"></i>'+v.data+'</h5>'+
                                    '<h5>'+
                                        '<p class="card-text"><b>Hor??rio: </b>'+v.horario+'<br>'+
                                        '<b>Quadra: </b>'+v.quadra+'<br>'+
                                        '<b>Endere??o: </b>'+''+v.rua+' - '+v.numero+', '+v.bairro+' , '+v.cidade+' - '+v.sigla+' <p>'+
                                        '<span class="botoes">'+
                                            '<button type="submit" onclick="candidataPelada('+v.id+')" class="btn btn-md mx-2 btn-success m-s btn-default" id ="botao-solicitacao">Candidatar</button>'+
                                        '</span>'+
                                    '</h5>'+
                                '</div>'+
                            '</div>'+
                        '</span>');
                });
            }else { 
               
                alertaFnc("Aten????o", retorno.mensagem, 2000, true, "warning");
            }
        }
    }); 
}

function editarPelada(id_pelada,id_localizacao){
    $.ajax({
        type: 'POST',
        url: 'pelada',
        data: 'acao=buscar_dados_para_edicao&id_pelada='+id_pelada+'&id_localizacao='+id_localizacao,
        dataType: 'json',
        beforeSend: function() {
          alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
        },
        success: function(retorno) {

            $("#id_pelada").val(retorno.idPelada);
            $("#id_localizacao").val(retorno.localizacao);
            $("#nomePelada").val(retorno.nome);
            $("#descricaoPelada").val(retorno.descricao);    
            $("#tempoJogo").val(retorno.duracaoPartida);
            $("#qtJogadores").val(retorno.qtJogadores);
            if(retorno.sorteio == "chegada"){
              $("#chegada").prop('checked',true);
              $("#chegada").val(retorno.sorteio);
            }else {
              $("#semSorteio").prop('checked',true);
              $("#semSorteio").val(retorno.sorteio);
            }
            if(retorno.status ==  "encerrada"){
                $("#dataPartida").prop('disabled',true);
                $("#horario").prop('disabled',true);
            }else{
                $("#dataPartida").prop('disabled',false);
                $("#horario").prop('disabled',false);
            }
            $("#dataPartida").val(retorno.dataPartida);
            $("#nomeQuadra").val(retorno.nomeQuadra);
            $("#rua").val(retorno.rua);
            $("#bairro").val(retorno.bairro);
            $("#numero").val(retorno.numero);
            $("#estado").val(retorno.estado);
            if(retorno.estado){

                $("#cidade").val(retorno.cidade);
            }            
            $("#horario").val(retorno.horario);

            $('#acao').val('atualizar');
            $(".botoes").hide();
            $(".tabela-pelada").hide();
            $("#cadastroPelada").fadeIn('normal');
        }
    });
}

function removerPelada(idPelada) {
    $.ajax({    
        type: 'POST',
        url: 'pelada',
        data: 'acao=remover_pelada&id_pelada='+idPelada,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Excluindo...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                atualizarListaPelada();
                alertaFnc("Sucesso", retorno.mensagem,2000, true, "success");
            } else {
                alertaFnc("Aten????o", retorno.mensagem,2000, true, "error");
            }
        }
    });   
}

function removerPeladeiroPelada(idPeladeiro,idPelada) {
    $.ajax({    
        type: 'POST',
        url: 'pelada',
        data: 'acao=remover_peladeiro_pelada&id_peladeiro='+idPeladeiro+'&id_pelada='+idPelada,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Excluindo...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                buscarPeladeiro(idPelada);
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
            } else {
                alertaFnc("Aten????o", retorno.mensagem,null, true, "error");
            }
        }
    });   
}

function infoPelada(idPelada) {
    $.ajax({    
        type: 'POST',
        url: 'pelada',
        data: 'acao=info_pelada&id_pelada='+idPelada,
        dataType:'json',
        beforeSend: function() {
           alertaFnc("Aguarde", "Buscando informa????es...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                $('#modal-pelada').html('');
                if (retorno.sucesso == true) {
                    $.each(retorno.html,function(i,v){
                      $('#modal-pelada').append('<div class="modal-header"><h4 class="modal-title">'+v.nome+'</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>'+
                        '<div class="modal-body"><p><strong>Descri????o: </strong>'+v.descricao+'</p>'+
                        '<hr><p><strong>Dura????o: </strong>'+v.duracao+'</p>'+
                        '<p><strong>Quantidade de jogadores: </strong>'+v.jogadores+'</p>'+
                        '<p><strong>Status da Pelada: </strong>'+v.status+'</p></div>');
                    });
                }
            }
        }
    });   
}


function candidataPelada(idPelada) {
    $.ajax({    
        type: 'POST',
        url: 'pelada',
        data: 'acao=enviar_solicitacao&id_pelada='+idPelada,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Enviando solicita????o...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                alertaFnc("Sucesso", retorno.mensagem,1500, true, "success");
                atualizarListaPelada();
            } else {
                alertaFnc("Aten????o", retorno.mensagem, 2000, true, "warning");
            }
        }
    });   
}

function montarEstado(){
    $.ajax({
        type: "POST",
        url: "pelada",
        data: 'acao=lista_estado',
        dataType: 'json',
        beforeSend: function() {

        },  
        success: function(retorno) 
        {
            if(retorno.sucesso === true) 
            {
                $.each(retorno.html,function(i,v) {
                  $('#estado').append('<option value="'+v.id+'">'+v.sigla+'</option>');
                });
            } 
        } 
   });
}

function montarCidade(){
    var estado = $('#estado').val();
    $('#cidade').html('<span class="mensagem">Aguarde, carregando ...</span>');  
    $.ajax({
        type: "POST",
        url: "pelada",
        data: 'acao=lista_cidade&id_estado='+estado,
        dataType: 'json',
        beforeSend: function() {

        },  
        success: function(retorno) 
        {
            $('#cidade').html('');
            if(retorno.sucesso === true) 
            {
                $.each(retorno.html,function(i,v) {
                  $('#cidade').append('<option value="'+v.id+'">'+v.nome+'</option>');
                });
            } 
        } 
    });
}

