$(document).ready(function() {

    $("#botao-cadastrar").bind('click',function(){
          $('#cadastroPelada').slideDown();
          $(".botoes").hide();
          $("#listaPelada").hide();
      });
      $('#botao-cancelar').bind('click',resetarFormulario);
      $('#form_cadastro_pelada').ajaxForm({ 
        dataType:  'json',
        beforeSend: validaForm,
        success:   tratarResultado 
      });
  atualizarListaPelada();
  montarEstado();
  montarCidade();

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
function atualizarListaPelada() {
  $.ajax({
      type: 'POST',
      url: 'pelada',
      data: 'acao=lista_pelada',
      dataType: 'json',
      success: function(retorno) {
        if (retorno.sucesso == true) {
            $.each(retorno.html,function(i,v){
              $('#listaPelada').append('<tbody><tr><td class="col-md-5">'+v.nome+'</td>'+
               '<td class="col-md-3"><button onclick="editarPelada('+v.id+')" class="btn btn-primary btn-xs">Editar</button></td>'+
               '<td class="col-md-3"><button onclick="removerPelada('+v.id+')" class="btn btn-danger btn-xs"> Excluir </ button></td></tr></tbody>');
            });
        }
      }
  }); 
}
function resetarFormulario(){
  $("#form_cadastro_pelada")[0].reset();
  $("#cadastroPelada").slideUp(function() {
     $("#listaPelada").show();
   });
  $("#listaPelada").reload();
   $(".botoes").show();
}
function editarPelada(idPelada){
   $.ajax({
      type: 'POST',
      url: 'pelada',
      data: 'acao=buscar_dados_para_edicao&id_pelada='+idPelada,
      dataType: 'json',
      beforeSend: function() {
            alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
      },
      success: function(retorno) {

        $("#id_pelada").val(retorno.idPelada);
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

        $('#acao').val('atualizar');
        $(".botoes").hide();
        $("#listaPelada").hide();
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
          location.reload(); 
          alertaFnc("Sucesso", retorno.mensagem,null, false, "success");

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
    $('#estado').change(function(e){
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
           //console.log(retorno.html);
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
 });
}

