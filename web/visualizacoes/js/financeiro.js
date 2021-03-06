$(document).ready(function() {  
    
    $('.dinheiro').bind('keypress',mask.money);
    $('.dinheiro').bind('keyup',mask.money);
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
        $(".botoes").show()
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
    atualizarListaLancamento();
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
            $('#lancamento-exibir').html('');
            if (retorno.sucesso == true) {
                if((retorno.html).length > 0){
                    $('.tabela-lancamento').show();
                    $.each(retorno.html,function(i,v){
                      $('#listaLancamento').append('<tr><td class="col-md-2">'+v.nome+'</td><td class="col-md-2">'+v.total+'</td>'+
                        '<td><button onclick="buscarPeladeiro('+v.id+','+v.pelada+')" title="Peladeiro confirmado" class="btn btn-info btn-xs" id="adiciona-lancamento"><i class="fas fa-user-check"></i></button></td>'+
                        '<td><button onclick="editarLancamento('+v.id+')" class="btn btn-primary btn-xs editar-pelada-'+v.id+'"><i class="fa fa-edit"></i></button></td>'+
                        '<td><button onclick="removerLancamento('+v.id+')" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></ button></td>'+
                        '</tr></tbody>');
                        if(v.status == 'encerrada'){
                            $('.editar-pelada-'+v.id).prop('disabled',true);
                        }
                    });
                } else{
                    $('#lancamento-exibir').show();
                    $('#lancamento-exibir').append('<div class="alert alert-warning" role="alert"><strong>Ol??!</strong> Voc?? n??o possui nenhum lan??amento</div>');
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
                var observacao;
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                        if(v.observacao){
                           observacao = v.observacao;
                        } else{
                            observacao = "";
                        }
                        $('#peladeiro-pagamento').append('<tr><td class="col-md-2">'+v.nome+'</td>'+
                            '<td class="col-md-2"><button onclick="infoPagamento('+v.id+','+idLancamento+')" title="Informa????es de pagamento do peladeiro" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modalPagamento" id="info-pagamento"><i class="fas fa-info-circle"></i></ button></td>'+
                            '<td class="col-md-2">'+observacao+'</td></tr></tbody>');
                        if(v.status == "Zerado"){
                            $('#info-pagamento').attr('disabled',true);
                        } 
                    });
                }else{
                    $('.busca-peladeiro-pagamento').hide();
                    $('#lancamento-exibir').show();
                    $('#lancamento-exibir').append('<div class="alert alert-info" role="alert"><strong>Ol??!</strong> Voc?? n??o foi possui nenhum peladeiro cadastrado, para convocar novos jogadores, clique <a href="peladeiro">aqui</a> .</div>');

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
function infoPagamento(idPeladeiro,idLancamento) {
    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=info_pagamento&id_peladeiro='+idPeladeiro+'&id_lancamento='+idLancamento,
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
                        if(v.status == "mensalista"){
                           valor = v.mensalidade;
                           status = "Mensalista";
                           debito = formatMoney(v.mensalidade - v.pagamento);
                        } else{
                            valor = v.diaria;
                            status = "Di??rista";
                            debito = formatMoney(v.diaria - v.pagamento);
                        }
                        if(v.lancamento_peladeiro){
                            $('#modal-pagamento').append('<div class="modal-header"><h4 class="modal-title">Pagamento</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>'+
                            '<div class="modal-body"><p><div class="form-group"><input type="radio" name="pagamento" id="pagamento-total" value="'+valor+'"> R$ '+valor+' '+
                            '<p><label>Observa????o:</label><textarea class="form-control" rows="3" id="observacao">'+v.observacao+'</textarea></p></div>'+
                            '<hr><p><strong>Status: </strong>'+status+'</p><button onclick="atualizaPagamento('+idPeladeiro+','+v.lancamento_peladeiro+')" class="btn btn-primary btn-default" id ="botao-pagamento">Atualizar pagamento</button>'+
                            '</div>');
                        } else {
                            $('#modal-pagamento').append('<div class="modal-header"><h4 class="modal-title">Pagamento</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>'+
                            '<div class="modal-body"><p><div class="form-group"><input type="radio" name="pagamento" id="pagamento-total" value="'+valor+'"> R$ '+valor+' '+
                            '<p><label>Observa????o:</label><textarea class="form-control" rows="3" id="observacao"> </textarea></p></div>'+
                            '<hr><p><strong>Status: </strong>'+status+'</p><button onclick="lancaPagamento('+idPeladeiro+','+v.id+')" class="btn btn-primary btn-default" id ="botao-pagamento">Lan??ar pagamento</button>'+
                            '</div>');
                        }
                        if(v.pagamento!="0.00" && v.pagamento!="0"){
                            $('input[type=radio]').attr('disabled',true);
                        }
                        $('input[type=radio]').on('change', function () {
                            var vlp = $('input[type=radio]:checked').val();
                            if(vlp !="undefined"){
                                valorPagamento = vlp;
                            } else{
                                valorPagamento = "";
                            }     
                        });

                    });  
                } 
            }
        }
    });   
}


function lancaPagamento(idPeladeiro,idFinanceiro) {
   var observacao = $('#observacao').val();
    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=adicionar_lancamento&id_peladeiro='+idPeladeiro+'&valorPagamento='+valorPagamento+'&id_financeiro='+idFinanceiro+'&observacao='+observacao,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Lan??ando pagamento...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
                window.location = 'financeiro';
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
            }
        }
    });   
}

function atualizaPagamento(idPeladeiro,idLancamento) {
   var observacao = $('#observacao').val();

    $.ajax({    
        type: 'POST',
        url: 'financeiro',
        data: 'acao=atualiza_lancamento&id_peladeiro='+idPeladeiro+'&valorPagamento='+valorPagamento+'&id_lancamento='+idLancamento+'&observacao='+observacao,
        dataType:'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Atualizando pagamento...", null, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso) {
                
                alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
                window.location = 'financeiro';
            } else {
                alertaFnc("Erro", retorno.mensagem,null, true, "error");
            }
        }
    });   
}

var mask = {
    money: function() {
        var el = this,exec = function(v) {
        v = v.replace(/\D/g,"");
        v = new String(Number(v));
        var len = v.length;
        if (1== len)
        v = v.replace(/(\d)/,"0.0$1");
        else if (2 == len)
        v = v.replace(/(\d)/,"0.$1");
        else if (len > 2) {
        v = v.replace(/(\d{2})$/,'.$1');
        }
        return v;
        };

        setTimeout(function(){
        el.value = exec(el.value);
        },1);
    }
}

function formatMoney(n, c, d, t) {
  c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}