$(document).ready(function() {
  $('#botao-cancelar').on('click',function() {
      history.back();
  });
  montarPosicao();
  montarTime();

  $('#form_cadastro_usuario').ajaxForm({ 

    dataType:  'json',
    beforeSend: validaForm,
    success:   tratarResultado 
  }); 
  $('#password').keyup(function() {
    $('#progresso').html(verificaForcaSenha($('#password').val()));
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
    alertaFnc("Sucesso", retorno.mensagem,null, true, "success");
  } else {
    alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
  }
}

function resetarFormulario(){
  $("#form_cadastro_usuario")[0].reset();
  window.location.assign('login');
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
