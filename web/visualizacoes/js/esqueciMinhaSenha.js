$(document).ready(function() { 
  
  $('#form_esqueci_senha').ajaxForm({ 
        dataType:  'json', 
        success:   validaForm 
    }); 
});

function validaForm (retorno) {  
  if(retorno.sucesso === true)
  {
    alertaFnc("Sucesso", retorno.mensagem,250, true, "success");
  } else {
   
    alertaFnc("Atenção", retorno.mensagem, null, true, "error");
  }
}