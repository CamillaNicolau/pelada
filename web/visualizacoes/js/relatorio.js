$(document).ready(function() {  
    $('#relatorio').change(function(){
        atualizarListaRelatorio($('#relatorio').val());
    });
});

function atualizarListaRelatorio(relatorio) {
    $.ajax({
        type: 'POST',
        url: 'relatorio',
        data: 'acao=lista_relatorio&tipo_relatorio='+relatorio,
        dataType: 'json',
        beforeSend: function() {
            alertaFnc("Aguarde", "Carregando...", 250, false, null);
        },
        success: function(retorno) {
            if (retorno.sucesso == true) {
                $('#listaRelatorio').html('');
                $.each(retorno.html,function(i,v){
                    if(v.tipo_relatorio == 1 || v.tipo_relatorio == 3){
                         $('#listaRelatorio').append(
                            '<thead>'+
                                '<tr>'+
                                  '<th scope="col">Pelada</th>'+
                                  '<th scope="col">Peladeiro</th>'+
                                  '<th scope="col">PDF</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tr>'+
                                '<td class="col-md-3">'+v.pelada+'</td>'+
                                '<td class="col-md-3">'+v.peladeiro+'</td>'+
                                '<td><button onclick="gerarPDF('+v.id+')" class="btn btn-primary btn-xs "><i class="far fa-file-pdf"></i></button></td>'+
                            '</tr>'
                        );
                    } else if(v.tipo_relatorio == 2){
                        $('#listaRelatorio').append(
                            '<thead>'+
                                '<tr>'+
                                  '<th scope="col">Pelada</th>'+
                                  '<th scope="col">Data</th>'+
                                  '<th scope="col">PDF</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tr>'+
                                '<td class="col-md-3">'+v.pelada+'</td>'+
                                '<td class="col-md-3">'+v.data_pelada+'</td>'+
                                '<td><button onclick="gerarPDF('+v.id+')" class="btn btn-primary btn-xs "><i class="far fa-file-pdf"></i></button></td>'+
                            '</tr>'
                        );
                        
                    }
                });
                
            }
                      
        }
    }); 
}