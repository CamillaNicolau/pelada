$(document).ready(function() {
montaPerfil();
  $("#botao-editar").bind('click',function(){
      $("#perfil").hide();
//      montarPosicao();
//      montarTime();
       editarUsuario();
  });
  $('#botao-cancelar').bind('click',resetarFormulario);
  $('#botao-desativar').bind('click',desativarUsuario);
  $('#form_editar_usuario').ajaxForm({ 
    dataType:  'json',
    beforeSend: validaForm,
    success:   tratarResultado 
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
  if(retorno.sucesso === true)
  {
    resetarFormulario();
    alertaFnc("Sucesso", retorno.mensagem, 250, false, "success");
  } else {
    alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
  }
}
function resetarFormulario(){
  $("#form_editar_usuario")[0].reset();
  $("#usuario").slideUp(function() {
    $("#perfil").show();
  });
}
function editarUsuario(){
  $.ajax({
    type: 'POST',
    url: 'perfil',
    data: 'acao=buscar_dados_para_edicao',
    dataType: 'json',
    beforeSend: function() {
          alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
    },
    success: function(retorno) {
      if (retorno.imagemUsuario !== '' && retorno.imagemUsuario !== null) {
          $("#imagem-perfil").html('<img src="' + retorno.imagemUsuario + '" class="rounded-circle" alt="Imagem"/>');
      } else {
          $("#imagem-perfil").html('');
      }
      $("#nomeUsuario").val(retorno.nomeUsuario);
      $("#emailUsuario").val(retorno.emailUsuario); 
      
      $("#apelidoUsuario").val(retorno.apelidoUsuario);
      $("#password").val(retorno.password);
      
      $("#posicao").val(retorno.posicao);
      $("#time").val(retorno.time);
      if(retorno.sexo == "f"){
        $("#feminino").prop('checked',true);
        $("#feminino").val(retorno.sexo);
      }else {
        $("#masculino").prop('checked',true);
        $("#masculino").val(retorno.sexo);
      }
      $("#perfil").hide();
      $("#usuario").fadeIn('normal');
    }
  });
}
function montaPerfil(){
    $.ajax({
    type: 'POST',
    url: 'perfil',
    data: 'acao=busca_dados_usuario',
    dataType: 'json',
    beforeSend: function() {
          alertaFnc("Aguarde", "Carregando os dados..", 250, false, null);
    },
    success: function(retorno) {

      $("#nomeUsuarioPerfil").text(retorno.nomeUsuario);
      if (retorno.imagemUsuario !== '' && retorno.imagemUsuario !== null) {
          $("#imagem-perfil").html('<img src="' + retorno.imagemUsuario + '" class="rounded-circle" alt="Imagem"/>');
      } else {
          $("#imagem-perfil").html('');
      }
    }
  });
}
function desativarUsuario(){
    $.ajax({
    type: 'POST',
    url: 'perfil',
    data: 'acao=desativar',
    dataType: 'json',
    beforeSend: function() {
          alertaFnc("Aguarde", "Desativando usuário..", 250, false, null);
    },
    success: function(retorno) {

       window.location.assign('logout');
    }
  });
}
function montarPosicao(){
  $.ajax({
    type: "POST",
    url: "usuario",
    data: 'acao=lista_posicao',
    dataType: 'json',
    beforeSend: function() {

    },  
    success: function(retorno) 
    {
      if(retorno.sucesso === true) 
      {
        $.each(retorno.html,function(i,v){
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
function montarTime(){
  $.ajax({
    type: "POST",
    url: "usuario",
    data: 'acao=lista_time',
    dataType: 'json',
    beforeSend: function() {

    },  
    success: function(retorno) 
    {
      if(retorno.sucesso === true) 
      {
        $.each(retorno.html,function(i,v){
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
