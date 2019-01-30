$(document).ready(function() {

    $("#botao-cadastrar").bind('click',function(){
        $('#cadastroPelada').slideDown();
        $(".botoes").hide();
        $(".tabela-pelada").hide();
    });
    $('#botao-cancelar').bind('click',resetarFormulario);
    

    $("#botao-busca-pelada").bind('click',function(){
        $('.busca-pelada').slideDown();
        $(".botoes").hide();
        $(".tabela-pelada").hide();
    });

    $("#encontra-pelada").bind('click',function(){
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
    if($('#estado').val() != ""){
        montarCidade();
    }
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
    
      montarEstado();
      montarCidade();
      atualizarListaPelada();
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
        success: function(retorno) {
            $('#listaPelada').html('');
            if (retorno.sucesso == true) {
                $.each(retorno.html,function(i,v){
                  $('#listaPelada').append('<tr><td class="col-md-2">'+v.nome+'</td><td class="col-md-2">'+v.data_partida+'</td>'+
                    '<td class="col-md-2">'+v.horario+'</td>'+
                    '<td><button onclick="buscarPeladeiro('+v.idPelada+')" title="adicionar peladeiro" class="btn btn-info btn-xs "><i class="fas fa-user-plus"></i></button></td>'+
                    '<td><button onclick="editarPelada('+v.idPelada+','+v.idLocalizacao+')" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></button></td>'+
                    '<td><button onclick="removerPelada('+v.idPelada+')" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></ button></td></tr></tbody>');
                });
            }
        }
    }); 
}

function buscarPeladeiro(id_pelada){
    $('.adicionar-peladeiro').show();
    $(".botoes").hide();
    $(".tabela-pelada").hide();
   
    $.ajax({
        type: 'POST',
        url: 'pelada',
        data: 'acao=buscar_peladeiro&id_pelada='+id_pelada,
        dataType: 'json',
        success: function(retorno) {
            $('#adicionar-peladeiro').html('');
            $('#id-pelada').html('');
            if (retorno.sucesso == true) {
                 var disable;
                $.each(retorno.html,function(i,v){

                    if(v.idCad){
                        disable = 'disabled="disable"';
                    }else{
                        disable = "";
                    }
                    $('#adicionar-peladeiro').append('<div><input type="checkbox" aria-label="Chebox para permitir input text" name="peladeiro[]" value="'+v.id+'" '+disable+'> <strong>'+v.nome+'</strong> - '+v.email+'<br>'+
                    '<input name="email" value="'+v.email+'" id="email" type="hidden" /> <button onclick="removerPeladeiroPelada('+v.id+','+retorno.id_pelada+')" class="btn btn-danger btn-xs"> <i class="fas fa-trash"></i></ button><div>');
                    
                });
                $('#id-pelada').append('<input name="pelada" value="'+retorno.id_pelada+'" id="pelada" type="hidden" />');
            }

        }
    }); 
}

function resetarFormulario(){
    $("#form_cadastro_pelada")[0].reset();
    $("#cadastroPelada").slideUp(function() {
       $('.tabela-pelada').show();
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
                  $('#pelada').append('<p><h3><strong>'+v.nome+'</strong>'+
                    '<br>Dia:'+v.data+'  -  Hora:'+v.horario+
                    '<p>'+v.rua+','+v.numero+' - '+v.bairro+', '+v.cidade+' - '+v.sigla+'</p> '+
                    '<button type="submit" onclick="candidataPelada('+v.id+')" class="btn btn-lg btn-success btn-default" id ="botao-solicitacao">Candidatar</button>');
                });
            }else { 
               
                alertaFnc("Atenção", retorno.mensagem, null, true, "warning");
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
            atualizarListaPelada();
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
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
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
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
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
            alertaFnc("Aguarde", "Enviando solicitação...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
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
                    var selectEstado = document.getElementById("estado");
                    var opt0 = document.createElement("option");
                    opt0.value = v.id;
                    opt0.text = v.sigla;
                    selectEstado.add(opt0);
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
            if(retorno.sucesso === true) 
            {
                $.each(retorno.html,function(i,v) {
                    var selectCidade = document.getElementById("cidade");
                    var opt0 = document.createElement("option");
                    opt0.value = v.id;
                    opt0.text = v.nome;
                    selectCidade.add(opt0);
                });
            } 
        } 
    });
}

