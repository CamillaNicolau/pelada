$(document).ready(function() {
  montaImagem();
  contarNotificacao();

  var screenSize = $(window).width();

  if(screenSize < 768){
    $('#navbar-fixed').addClass('collapsed-navbar');
  }

  $('.navbar-toggler-icon').click(function(){
    $(this).closest('#navbar-fixed').toggleClass('collapsed-navbar');
  });
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

function contarNotificacao(){
    $.ajax({
        type: 'POST',
        url: 'notificacao',
        data: 'acao=conta_notificacao',
        dataType: 'json',
        beforeSend: function() {
        },
        success: function(retorno) {
            if (retorno.sucesso == true) {
                $('.badge').html('');
                if((retorno.html).length > 0){
                    $.each(retorno.html,function(i,v){
                      if(v.total > 0){
                        $('.badge').append(v.total);

                      }
                        
                    });
                } 
            }
        }
    }); 
}
