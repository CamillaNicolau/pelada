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
           // $.each(retorno.html,function(i,v){
              $('#listaPeladeiro').append('<tr><td><img src=visualizacoes/imagens/usuario/mini_21616243_1692720580740111_4603407605843624647_n.jpg class="rounded-circle"/></td>'+
               '<td >Camilla</td><td class="col-md-3"><button onclick="editarPeladeiro()" class="btn btn-default glyphicon glyphicon-pencil">Editar</button></td>'+
               '<td "><button onclick="removerPeladeiro()" class="btn btn-danger"> Excluir </ button></td></tr>');
           // });
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