$(document).ready(function() { 
  $('#form_cadastra_senha').ajaxForm({ 
        dataType:  'json',
      beforeSend: validaForm,
      success:   tratarResultado
    });
    $('#password').keyup(function() {
    $('#progresso').html(verificaForcaSenha($('#password').val()));
  }); 
});

function validaForm () {  

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
       window.location = 'login';
    alertaFnc("Sucesso", retorno.mensagem, 250, false, "success");
  } else {
    alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
  }
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
