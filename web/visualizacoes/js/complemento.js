// Exemplos
// alertaFnc("Atenção", status['mensagem'], null, true, "error");
// alertaFnc("Aguarde", "Salvando dados pessoais...", null, false, null);
function alertaFnc(titulo, mensagem, tempo, botao, tipo)
{
    swal({
        title: titulo,
        text: mensagem,
        html: true,
        animation: "none", 
        timer: tempo,
        showConfirmButton: botao,
        type: tipo
    });
}