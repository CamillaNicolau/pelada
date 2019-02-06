$(document).ready(function() {
  montaImagem();

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
            $("#imagem-perfil-menu").html('<img src="' + retorno.imagemUsuario + '" class="rounded-circle mw-100" alt="Imagem"/>');
        } else {
            $("#imagem-perfil-menu").html('');
        }
    }
  });
}

