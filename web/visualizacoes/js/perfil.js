$(document).ready(function() {

  $('#botao-desativar').bind('click',desativarUsuario);
  $('#form_editar_usuario').ajaxForm({ 
    dataType:  'json',
    beforeSend: validaForm,
    success:   tratarResultado 
  });
  $('#password').keyup(function() {
    $('#progresso').html(verificaForcaSenha($('#password').val()));
  });

  montaPerfil();
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
  window.location.assign('inicio');
}
function montaPerfil(){
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
          $("#imagem-perfil").html('<img src="' + retorno.imagemUsuario + '" class="rounded-circle mw-100" alt="Imagem"/>');
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
      $("#usuario").fadeIn('normal');
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
        alertaFnc("Aguarde", "Você está prestes a desativar sua conta, você tem CERTEZA que deseja continuar?", null, true, null);
    },
    success: function(retorno) {

       window.location.assign('logout');
    }
  });
}
function verificaForcaSenha(senha) {
  var forca = 0
  if (senha.length < 8) {
    $('#progresso').removeClass().addClass('verificacao');
    return 'A senha deve conter mais de 8 caracteres';
  }
  if (senha.length > 8) {
      forca += 1;
  }
  // Verifica se a senha possui caracter maiusculo e minusculo, para aumentar a força.
  if (senha.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
      forca += 1;
  } 
  // Verifica se a senha possui letras e numeros, para aumentar a força.
 if (senha.match(/([a-zA-Z])/) && senha.match(/([0-9])/)) {
      forca += 1;
  } 
  // Verifica se a senha possui caracter especial, para aumentar a força.
  if (senha.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
      forca += 1;
  } 
  // Verifica se a senha possui mais de um caracter especial, para aumentar a força.
  if (senha.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) {
      forca += 1;
  } 
  // Calcula a força
  if (forca < 2) {
    $('#progresso').removeClass().addClass('progress-bar bg-danger');
    return 'Fraco';
  } else if (forca == 2) {
    $('#progresso').removeClass().addClass('progress-bar bg-warning');
    return 'Médio';
  } else {
    $('#progresso').removeClass().addClass('progress-bar bg-success');
    return 'Forte'
  }
}
