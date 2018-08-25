$(document).ready(function() { 
  $('#botao-cadastrar').bind('click', cadastroUsuarios);  
  $('#form_login').ajaxForm({ 
        dataType:  'json', 
        success:   validaForm 
    }); 
});
function cadastroUsuarios() {
    window.open('usuario', '_self');
}
function validaForm (retorno) {  
  if(retorno.sucesso === true)
  {
    window.location = 'inicio';
  } else {
    alertaFnc("Atenção", retorno.mensagem, null, true, "error");
  }
}