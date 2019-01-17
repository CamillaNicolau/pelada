$(document).ready(function() {

    $("#botao-cadastrar").bind('click',function(){
        $('#cadastroPeladeiro').slideDown();
        $(".botoes").hide();
        $("#listaPeladeiro").hide();
    });
    $('#botao-cancelar').bind('click',resetarFormulario);
    $('#form_cadastra_peladeiro').ajaxForm({ 
        dataType:  'json',
        beforeSend: validaForm,
        success:   tratarResultado 
    });
    atualizarListaPeladeiro();
    montarPosicao();
    montarTime();

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
    alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
  } else {
    alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
  }
}
function atualizarListaPeladeiro() {
  $.ajax({
      type: 'POST',
      url: 'peladeiro',
      data: 'acao=lista_peladeiro',
      dataType: 'json',
      success: function(retorno) {
        if (retorno.sucesso == true) {
            $.each(retorno.html,function(i,v){
              $('#listaPeladeiro').append('<tbody><tr><td>'+v.nome+'</td><td >'+v.email+'</td><td><button onclick="editarPeladeiro('+v.id+')" class="btn btn-primary btn-xs "><i class="fa fa-edit"></i></button></td>'+
                   '<td><button onclick="removerPeladeiro('+v.id+')" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></ button></td></tr></tbody>');
            });
        }
      }
  }); 
}
function resetarFormulario(){
  $("#form_cadastra_peladeiro")[0].reset();
  $("#cadastroPeladeiro").slideUp(function() {
     $("#listaPeladeiro").show();
   });
 
   $(".botoes").show();
}
function montarPosicao(){
 $.ajax({
  type: "POST",
  url: "peladeiro",
  data: 'acao=lista_posicao',
  dataType: 'json',
  beforeSend: function() {

  },  
  success: function(retorno) 
  {
    if(retorno.sucesso === true) 
    {
      $.each(retorno.html,function(i,v) {
        var selectTime = document.getElementById("posicao");
        var opt0 = document.createElement("option");
        opt0.value = v.id;
        opt0.text = v.nome;
        selectTime.add(opt0);
      });
    } 
   } 
  });
}

function editarPeladeiro(idPeladeiro){
    $.ajax({
        type: 'POST',
        url: 'peladeiro',
        data: 'acao=buscar_dados_para_edicao&id_peladeiro='+idPeladeiro,
        dataType: 'json',
        beforeSend: function() {
          alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
        },
        success: function(retorno) {
            $("#id_peladeiro").val(retorno.idPeladeiro);
            $("#nomePeladeiro").val(retorno.nome);
            $("#emailPeladeiro").val(retorno.email);    
            $("#telPeladeiro").val(retorno.telefone);
            $("#dataNascimento").val(retorno.data_nasimento);
            if(retorno.sorteio == "diarista"){
              $("#diarista").prop('checked',true);
              $("#diarista").val(retorno.participacao);
            }else {
              $("#mensalista").prop('checked',true);
              $("#mensalista").val(retorno.participacao);
            }
            $("#dataPartida").val(retorno.dataPartida);
            $("#posicao").val(retorno.posicao);
            $("#time").val(retorno.time);
            $('#acao').val('atualizar');
            $(".botoes").hide();
            $("#listaPeladeiro").hide();
            $("#cadastroPeladeiro").fadeIn('normal');
            atualizarListaPeladeiro();
        }
    });
}

function montarTime(){
 $.ajax({
  type: "POST",
  url: "peladeiro",
  data: 'acao=lista_time',
  dataType: 'json',
  beforeSend: function() {

  },  
  success: function(retorno) 
  {
      if(retorno.sucesso === true) 
      {
        $.each(retorno.html,function(i,v) {
          var selectTime = document.getElementById("time");
          var opt0 = document.createElement("option");
          opt0.value = v.id;
          opt0.text = v.nome;
          selectTime.add(opt0);
        });
      } 
    } 
  });
}
