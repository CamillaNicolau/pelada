$(document).ready(function() {
  montaImagem();
          console.log('aqui');

});
function montaImagem(){
  $.ajax({
    type: 'POST',
    url: 'perfil',
    data: 'acao=buscar_dados_para_edicao',
    dataType: 'json',
    beforeSend: function() {
    },
    success: function(retorno) {
        if (retorno.imagemUsuario !== '' && retorno.imagemUsuario !== null) {
            $("#imagem-perfil-menu").html('<img src="' + retorno.imagemUsuario + '" class="rounded-circle" alt="Imagem"/>');
        } else {
            $("#imagem-perfil-menu").html('');
        }
    }
  });
}

