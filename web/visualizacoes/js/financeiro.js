$(document).ready(function() {  
    $("#botao-cadastrar").bind('click',function(){
        $('#lancamentoPelada').slideDown();
        $(".botoes").hide();
        $('#lancamento-exibir').hide();
        $('.tabela-lancamento').hide();
        
    });
    $('#botao-cancelar').bind('click',resetarFormulario);
    $('#botao-cancelar-lancamento').bind('click',function(){
        $('.busca-peladeiro-pagamento').hide();
        $('#lancamento-exibir').hide();
        atualizarListaLancamento();
    });
    montarPelada();
    $('#form_lancamento').ajaxForm({ 
      dataType:  'json',
      beforeSend: validaForm,
      success:   tratarResultado 
    });
    atualizarListaLancamento();

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
      atualizarListaLancamento();
      alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
    } else {
      alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
    }
}

function resetarFormulario(){
  $("#form_lancamento")[0].reset();
  $("#lancamentoPelada").slideUp(function() {
    $('.tabela-lancamento').show();
  });
  $(".botoes").show();
}

function atualizarListaLancamento() {
    $.ajax({
        type: 'POST',
        url: 'financeiro',
        data: 'acao=lista_lancamento',
        dataType: 'json',
        success: function(retorno) {
            $('#listaLancamento').html('');
            if (retorno.sucesso == true) {
                if((retorno.html).length > 0){
                    $('.tabela-lancamento').show();
                    $.each(retorno.html,function(i,v){
                      $('#listaLancamento').append('<tr><td class="col-md-2">'+v.nome+'</td><td class="col-md-2">'+v.total+'</td>'+
                        '<td><button onclick="buscarPeladeiro('+v.id+','+v.pelada+')" title="adicionar lançamento" class="btn btn-info btn-xs" id="adiciona-lancamento"><i class="fas fa-dollar-sign"></i></button></td>'+
                        '<td><button onclick="editarLancamento('+v.id+')" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></button></td>'+
                        '<td><button onclick="removerLancamento('+v.id+')" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></ button></td>'+
                        '</tr></tbody>');
                    });
                } else{
                    $('#lancamento-exibir').show();
                    $('#lancamento-exibir').append('<div class="alert alert-info" role="alert"><strong>Olá!</strong> Você não possui nenhuma lançamento</div>');
                }
            }
        }
    }); 
}

function montarPelada(){
    $.ajax({
        type: "POST",
        url: "financeiro",
        data: 'acao=busca_pelada',
        dataType: 'json',
        beforeSend: function() {

        },  
        success: function(retorno) 
        {
            if(retorno.sucesso === true) 
            {
                $.each(retorno.html,function(i,v) {
                  $('#pelada').append('<option value="'+v.id+'">'+v.nome+'</option>');
                });
            } 
        } 
   });
}

function buscarPeladeiro(idLancamento,idPelada) {
    $('.busca-peladeiro-pagamento').show();
    $(".botoes").hide();
    $(".tabela-lancamento").hide();
    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=buscar_peladeiro&id_lancamento='+idLancamento+'&id_pelada='+idPelada,
        dataType:'json',
        beforeSend: function() {
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                $('#peladeiro-pagamento').html('');
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        $('#peladeiro-pagamento').append('<tr><td class="col-md-2">'+v.nome+'</td>'+
                            '<td><button onclick="infoPagamento('+v.id+')" title="Informações de pagamento da pelada" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalPagamento" id="info-pagamento"><i class="fas fa-info-circle"></i></ button></td>'+
                            '</tr></tbody>');
                        if(v.status != "" && v.status != "Débito"){
                            $('#info-pagamento').attr('disabled',true);
                        } 
                    });
                }else{
                    $('.busca-peladeiro-pagamento').hide();
                    $('#lancamento-exibir').show();
                    $('#lancamento-exibir').append('<div class="alert alert-info" role="alert"><strong>Olá!</strong> Você não foi possui nenhum peladeiro cadastrado, para convocar novos jogadores, clique <a href="peladeiro">aqui</a> .</div>');

                }
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
            }
        }
    });   
}


function editarLancamento(idLancamento){
    $.ajax({
        type: 'POST',
        url: 'financeiro',
        data: 'acao=buscar_dados&id_lancamento='+idLancamento,
        dataType: 'json',
        beforeSend: function() {
          alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
        },
        success: function(retorno) {
            $("#id_lancamento").val(retorno.idLancamento);
            $("#valorMensalista").val(retorno.mensalidade);
            $("#valorDiaria").val(retorno.diaria);
            $("#valorTotal").val(retorno.totalPelada);
            $("#pelada").val(retorno.pelada);
         
            $('#acao').val('atualizar');
            $("#lancamentoPelada").fadeIn('normal');
            $(".botoes").hide();
            $('#lancamento-exibir').hide();
            $('.tabela-lancamento').hide();   
        }
    });
}

function removerLancamento(idLancamento) {
    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=remover_lancamento&id_lancamento='+idLancamento,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Excluindo...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                atualizarListaLancamento();
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
            }
        }
    });   
}
var valorPagamento;
var statusPagento;
function infoPagamento(idPeladeiro) {
    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=info_pagamento&id_peladeiro='+idPeladeiro,
        dataType:'json',
        beforeSend: function() {
           
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                $('#modal-pagamento').html('');
                var valor;
                var status;
                if (retorno.sucesso == true) {
                    $.each(retorno.html,function(i,v){
                        if(v.status == "1"){
                           valor = v.mensalidade;
                           status = "Mensalista";
                        } else{
                            valor = v.diaria;
                            status = "Diárista";
                        }
                        
                        $('#modal-pagamento').append('<div class="modal-header"><h4 class="modal-title">Pagamento</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>'+
                            '<div class="modal-body"><p><div class="form-group"><input type="radio" name="pagamento" id="pagamento-total" value="'+valor+'"> R$ '+valor+' '+
                            '<input type="radio" name="pagamento" id="pagamento-parcial" value="outro"> Outro valor<input type="text" name="valor" class="form-control" id="valor-parcial"></p></div>'+
                            '<hr><p><strong>Status: </strong>'+status+'</p><button onclick="lancaPagamento('+idPeladeiro+','+v.id+')" class="btn btn-primary btn-default" id ="botao-pagamento">Lançar pagamento</button>'+
                            '</div>');
                        $('#valor-parcial').hide();
                        $('input[type=radio]').on('change', function () {
                            var pagamento = $('input[type=radio]:checked').val();
                            if(pagamento == 'outro'){
                                $('#valor-parcial').slideDown();

                            } else{
                                $('#valor-parcial').slideUp();
                                valorPagamento = $('#pagamento-total').val();
                                $('#valor-parcial').val('');
                            }
                            
                        });
                                          
                    });
                   
                }
            }
        }
    });   
}

function lancaPagamento(idPeladeiro,idFinanceiro) {
   var valor = $('#valor-parcial').val();
   var pagamento =  valor ? valor : valorPagamento;

    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=adicionar_lancamento&id_peladeiro='+idPeladeiro+'&valorPagamento='+pagamento+'&id_financeiro='+idFinanceiro+'&pagamentoReal='+valorPagamento,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Lançando pagamento...", null, false, null);
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