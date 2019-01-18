$(document).ready(function() {
  
  $('#form_esqueci_senha').ajaxForm({ 
        dataType:  'json', 
        beforeSubmit: validaForm,
        success: tratarResultado
    }); 
});

function validaForm(){
    if(true){
        alertaFnc("Aguarde", "Enviando solicitação...", null, true, null);
        return true;
    } else {
        return false;
    }
}

function tratarResultado (retorno) {  
  if(retorno.sucesso === true)
  {
    alertaFnc("Sucesso", retorno.mensagem,null, true, "success");
    window.location.href = 'login';
  } else {
    alertaFnc("Erro", retorno.mensagem,null, true, "error"); 
  }
}
