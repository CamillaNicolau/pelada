<?php

/**
 * Gerencia a exibição da página de relatorio.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class RelatorioControle
{

    public function tratarAcoes()
    {
      if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
          case 'lista_relatorio':
            try{
              
                $Pelada = PeladaRepositorio::buscaGeralPelada();
                foreach ($Pelada as $peladeiro){
                    var_dump($peladeiro->nome);
                }
                
                exit(json_encode($retorno));
            } catch (Erro $E){
              
            }
            break;
/**
 * Arquivo de controle da página de propostas.
 *
 * @author Eduardo Resende <eduardo@eduardoresende.com>
 * @copyright Copyright (c) 2018, Vector Internet
 */

//require_once('plugveiculos.config.php');
//
//switch ($_REQUEST['acao']) {
//    case "listar_veiculos":
//        try {
//            $tipoVeiculo = $_POST['tipo_veiculo'];
//            $idLoja = $_POST['id_loja'];
//            $carros = PlugveiculosCarrosLojas::buscar(null, PlugveiculosCarrosSituacoes::ESTOQUE, 'ativo', (string) $tipoVeiculo, $idLoja);
//            $dados = [];
//            $dados[] = '<option>Selecione um veículo</option>';
//            foreach ($carros as $dadosCarro) {
//                $valorNome = ($dadosCarro->valor ? ' (R$ ' . Util::floatToMoney($dadosCarro->valor) . ')' : '');
//                $valorData = ($dadosCarro->valor ? Util::floatToMoney($dadosCarro->valor) : '');
//                $dados[] = '<option value="' . $dadosCarro->id_carro_loja . '" data-valor="' . $valorData . '" data-cor="' . $dadosCarro->cor . '">' . $dadosCarro->nome_completo . $valorNome . '</option>';
//            }
//            Log::registrar(Log::TIPO_SELECT, Log::plugveiculos("propostas", "listar"), "Listagem dos veículos cadastrados com proposta.");
//            Util::exitJson(['sucesso' => true, 'html' => (count($carros) ? implode('', $dados) : '')]);
//        
//        } catch (ExcecaoPlugveiculos $e) {
//            Util::exitJson(['sucesso' => false, 'erro' => true]);
//        }
//        break;
//    case "cadastrar_proposta":
//        try {
//
//            $idLead = $_POST['lead'];
//            $tipoVeiculo = $_POST['tipo_veiculo'];
//            $idLoja = $_POST['loja'];
//            $idVeiculos = $_POST['veiculos'];
//            $valorVeiculo = $_POST['valor_veiculo'];
//            $cor = $_POST['cor_veiculo'];
//            $observacoes = $_POST['observacoes'] ? $_POST['observacoes'] : NULL;
//            $valorEntrada = ((isset($_REQUEST['valor_entrada']) && empty($_REQUEST['valor_entrada'])) ? NULL : $_POST['valor_entrada']);
//            $numeroParcelas = $_POST['numero_parcelas'] ? $_POST['numero_parcelas'] : NULL;
//            $valorFinanciado = $_POST['valor_financiado'] ? $_POST['valor_financiado'] : NULL;
//            $nomePlano = $_POST['nome_plano'] ? $_POST['nome_plano'] : NULL;
//            $numeroParcelasConsorcio = $_POST['numero_parcelas_consorcio'] ? $_POST['numero_parcelas_consorcio'] : NULL;
//            $valorParcela = $_POST['valor_parcela'] ? $_POST['valor_parcela'] : NULL;
//            $idVendedor = $_POST['id_vendedor'];
//            $validadeProposta = $_POST['validade_proposta'];
//
//            Doctrine::beginTransaction();
//            
//            $Proposta = new PlugveiculosPropostas();
//            $Proposta->tipo_veiculo = $tipoVeiculo;
//            $Proposta->valor_veiculo = Util::moneyToFloat($valorVeiculo);
//            $Proposta->cor = $cor;
//            $Proposta->observacoes = $observacoes;
//            $Proposta->valor_entrada = Util::moneyToFloat($valorEntrada);
//            $Proposta->numero_parcelas = $numeroParcelas;
//            $Proposta->valor_financiado = Util::moneyToFloat($valorFinanciado);
//            $Proposta->nome_plano = $nomePlano;
//            $Proposta->numero_parcelas_consorcio = $numeroParcelasConsorcio;
//            $Proposta->valor_parcela = Util::moneyToFloat($valorParcela);
//            $Proposta->validade_proposta = date('Y-m-d', strtotime('+' . $validadeProposta . ' days',strtotime(date('Y-m-d')))) . ' 00:00:00';
//            $Proposta->setLead(new PlugveiculosLeadsContatos($idLead));
//            $Proposta->setLoja(new PlugveiculosLojas($idLoja));
//            $Proposta->setVeículo(new PlugveiculosCarrosLojas($idVeiculos));
//            $Proposta->setUsuario(new Usuario($idVendedor));
//            $Proposta->adicionar();
//
//            $dados = PlugveiculosPropostas::buscar(null, $Proposta->id_proposta)[0];
//            $imagemVeiculo = PlugveiculosCarrosFotos::buscar((int)$dados->fk_carro, null, ['ordem','ASC'])[0];
//
//            if (!is_dir(URL_PLUGVEICULOS_PDF)) {
//                mkdir(URL_PLUGVEICULOS_PDF);
//            }
//            $arquivo = URL_PLUGVEICULOS_PDF . '/proposta-' . $Proposta->id_proposta . '.pdf';
//            $validade = explode(' ', $dados->validade_proposta);
//            $Loja = new PlugveiculosLojas();
//            $Loja->setTelefones(new PlugveiculosTelefones($dados->telefones_loja));
//            $DadosSite = PlugdadosDados::getDadosPadrao();
//            $nomeSite = $DadosSite->nome_site;
//            $telefones = $Loja->getTelefones();
//            $nomeVeiculo = $dados->nome_completo . '/' . $dados->ano_fabricacao;
//            $nomeLeadCompleto = $dados->nome . ' ' . $dados->sobrenome;
//
//            $html = [];
//            $html[] = '<style>@page {margin-top: 35px; margin-bottom: 30px;}</style>';
//            $html[] = '<div style="width: 100%; height: auto; border-bottom: solid 1px #000; margin-bottom: 15px;">';
//            $html[] = '    <img src="' . URL_PLUGVEICULOS_LOGOS . $dados->logomarca_loja . '" height="90" title="' . $dados->nome_loja . '" alt="' . $dados->nome_loja . '" />';
//            $html[] = '</div>';
//            $html[] = '<div style="width: 50%; height: auto; float: left;">';
//            $html[] = '    <h1 style="width: 95%; margin: 0px; font-family: Arial; font-size: 16px; font-weight: normal; text-transform: uppercase;">';
//            $html[] =         $nomeVeiculo . ($dados->cor ? ' - ' . $dados->cor : '');
//            $html[] = '    </h1>';
//            $html[] = '    <div style="width: 95%; margin: 10px 0">';
//            $html[] =          '<img src="' . $imagemVeiculo->url_grande . '" width="100%" />';
//            $html[] = '    </div>';
//            $html[] = '    <div style="width: 95%; font-family: Arial; font-size: 10px;">';
//            $html[] =          $dados->descricao;
//            $html[] = '    </div>';
//            $html[] = '</div>';
//            $html[] = '<div style="width: 50%; height: auto; font-family: Arial; float: right;">';
//            $html[] = '    <div style="width: 95%; height: auto; background: #F2F2F2; float: right; padding: 8px 0">';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//            $html[] = '             Nome';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              $nomeLeadCompleto;
//            $html[] = '        </div>';
//            if ($dados->telefone) {
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right; margin-top: 5px;">';
//                $html[] = '             Telefone';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =              Util::IntToTel($dados->telefone);
//                $html[] = '        </div>';
//            }
//            if ($dados->celular) {
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right; margin-top: 5px;">';
//                $html[] = '             Celular';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =              Util::IntToTel($dados->celular);
//                $html[] = '        </div>';
//            }
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right; margin-top: 10px;">';
//            $html[] = '             E-mail';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; float: right;">';
//            $html[] =              $dados->email;
//            $html[] = '        </div>';
//            $html[] = '    </div>';
//            $html[] = '    <div style="width: 95%; height: auto; float: right; padding: 8px 0; margin-top: 12px;">';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; font-weight: bold; float: right; border-bottom: solid 1px #000; padding-bottom: 6px;">';
//            $html[] = '             Condições';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right; margin-top: 8px;">';
//            $html[] = '             Valor do Veículo';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              'R$ ' . Util::floatToMoney((float)$dados->valor_veiculo);
//            $html[] = '        </div>';
//            if ($dados->valor_entrada) {
//                $html[] = '        <div style="width: 98%; font-size: 14px; text-transform: uppercase; font-weight: bold; float: right; margin: 6px 0;">';
//                $html[] = '            - Financiamento';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//                $html[] = '             Entrada';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =              'R$ ' . Util::floatToMoney((float)$dados->valor_entrada);
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//                $html[] = '             Parcelas';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =               $dados->numero_parcelas . ' de R$ ' . Util::floatToMoney((float)$dados->valor_financiado);
//                $html[] = '        </div>';
//            }
//            if ($dados->nome_plano) {
//                $html[] = '        <div style="width: 98%; font-size: 14px; text-transform: uppercase; font-weight: bold; float: right; margin: 6px 0;">';
//                $html[] = '            - Consórcio';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//                $html[] = '             Nome do Plano';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =              $dados->nome_plano;
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//                $html[] = '             Parcelas';
//                $html[] = '        </div>';
//                $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//                $html[] =               $dados->numero_parcelas_consorcio . ' de R$ ' . Util::floatToMoney((float)$dados->valor_parcela);
//                $html[] = '        </div>';
//            }
//            $html[] = '    </div>';
//            $html[] = '    <div style="width: 95%; height: auto; background: #F2F2F2; float: right; padding: 8px 0; margin-top: 5px;">';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//            $html[] = '             Data de validade desta proposta';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              Util::converteData($validade[0], 'd/m/Y');
//            $html[] = '        </div>';
//            $html[] = '    </div>';
//            $html[] = '    <div style="width: 95%; height: auto; float: right; padding: 8px 0; margin-top: 12px;">';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; font-weight: bold; float: right; border-bottom: solid 1px #000; padding-bottom: 6px;">';
//            $html[] = '             Vendedor';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right; margin-top: 8px;">';
//            $html[] = '             Nome';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              $dados->nome_vendedor;
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//            $html[] = '             Loja';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              $dados->nome_loja;
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//            $html[] = '             Telefone';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              Util::IntToTel($telefones->telefone_principal);
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 12px; text-transform: uppercase; font-weight: bold; float: right;">';
//            $html[] = '             Whatsapp';
//            $html[] = '        </div>';
//            $html[] = '        <div style="width: 98%; font-size: 16px; text-transform: uppercase; float: right;">';
//            $html[] =              Util::IntToTel($telefones->telefone_alternativo);
//            $html[] = '        </div>';
//            $html[] = '    </div>';
//            $html[] = '</div>';
//            $html[] = '<div style="width: 100%; height: auto; border-top: solid 1px #000; font-family: Arial; font-size: 8px; margin-top: 15px; padding-top: 6px;">';
//            $html[] = '    Foto e proposta meramente ilustrativa, os valores informados estão sujeitos a alterações sem aviso prévio. Sujeito a disponibilidade de estoque. Frete não incluso. Eventuais falhas de digitação ou mudanças de tabela podem ocorrer, portanto os valores deverão ser confirmados no momento da compra. Crédito sujeito a aprovação pelo banco';
//            $html[] = '</div>';
//            
//            $mpdf = new \Mpdf\Mpdf();
//            $mpdf->SetDisplayMode('fullpage');
//            $mpdf->WriteHTML(implode('', $html));
//            $mpdf->Output($arquivo, \Mpdf\Output\Destination::FILE);
//
//            if (Util::validarEmail($dados->email)) {
//                $valores_proposta_tpl = [
//                    '%nome_concessionaria%'=> $dados->nome_concessionaria,
//                    '%nome_loja%' => $dados->nome_loja,
//                    '%numero_proposta%' => $dados->id_proposta,
//                    '%data_proposta%' => date('d/m/Y'),
//                    '%nome%' => $nomeLeadCompleto,
//                    '%nome_vendedor%' => $dados->nome_vendedor,
//                    '%link_proposta%' => Util::getShortUrl(URL_ARQUIVOS . 'plugveiculos/propostas/proposta-' . $Proposta->id_proposta . '.pdf'),
//                    '%remote_addr%'=> $_SERVER['REMOTE_ADDR'],
//                    '%data_hora%'=> date('H:i \d\e d/m/Y'),
//                    '%nome_site%' => $nomeSite,
//                    '%url_raiz_site%'=> URL_RAIZ_SITE
//                ];
//
//                $Template = new TemplatesEmail($valores_proposta_tpl, 'plugveiculos_novaproposta');
//                $Carteiro = new Correio(
//                    $dados->email,
//                    '[Proposta ' . $dados->nome_loja . '] ' . $nomeVeiculo,
//                    $Template->getHtmlTemplates()
//                );
//                $Carteiro->ativar_html = true;
//                $Carteiro->addAnexo($arquivo);
//                $Carteiro->enviar();          
//
//                if (RDStation::rdstationAtivo()) {
//                    $dados_complementares['Nome'] = $nomeLeadCompleto;
//                    $dados_complementares['Telefone'] = ($dados->celular) ? $dados->celular : 'Não Informado';
//                    $dados_complementares['Veículo'] = $nomeVeiculo;
//                    $dados_complementares['Valor'] = $dados->valor_veiculo;
//                    $dados_complementares['Concessionária'] = $nomeSite;
//                    $dados_complementares['identificador'] = 'proposta';
//
//                    $RDStation = new RDStation($dados->email, $dados_complementares);
//                    $RDStation->enviarDados();
//                }
//
//            }
//
//            Doctrine::commit();
//            Log::registrar(Log::TIPO_INSERT, Log::plugveiculos("proposta", "inserir"), "Inclusão da proposta - ID: <strong>".$Proposta->id_proposta."</strong> para o lead: <strong>".$nomeLeadCompleto."</strong>");
//
//            Util::exitJson(['sucesso' => true, 'mensagem' => 'Proposta criada com sucesso!']);
//        } catch (ExcecaoPlugveiculos $e) {
//            Util::exitJson(['sucesso' => false, 'erro' => true]);
//        }
//        break;
//    case "listar_propostas":
//        try {
//            if (Plugveiculos::verificarPermissao(PlugveiculosUsuario::PRIVILEGIO_PROPOSTAS)) {
//                $idVendedor = null;
//            } else {
//                $idVendedor = Credencial::getUsuario()->id_usuario;
//            }
//            $Response = new VectorDev\AjaxTable\Response();
//
//            $params = $Response->getCustomParams();
//            $order = $Response->getOrderByForSql();
//            $limit = $Response->getLimitForSql();
//            
//            $search = isset($params['buscar']) && $params['buscar'] != '' ? $params['buscar'] : null;
//            $lead = isset($params['id_lead']) && $params['id_lead'] ? $params['id_lead'] : null;
//            $tipo = isset($params['tipo']) && $params['tipo'] ? $params['tipo'] : null;
//            $loja = isset($params['id_loja']) && $params['id_loja'] ? $params['id_loja'] : null;
//            $Response->setRowsTotal(PlugveiculosPropostas::countAll($search, $lead, $tipo, $loja, $idVendedor));
//            $propostas = PlugveiculosPropostas::buscar($search, null, $lead, $tipo, $loja, $idVendedor, $order, $limit);
//
//            foreach ($propostas as $dadosPropostas) {
//
//                $infoLead = $dadosPropostas->nome . ' ' . $dadosPropostas->sobrenome . '&#60;' . $dadosPropostas->email . '&#62;';
//
//                $diferenca = strtotime($dadosPropostas->validade_proposta) - strtotime(date('Y-m-d') . ' 00:00:00');
//                $dias = floor($diferenca / (60 * 60 * 24));
//                $infoValidade = ($dias <= '0') ? 'Vencida' : $dias . ' dias';
//                $validade = Util::converteData(explode(' ', $dadosPropostas->validade_proposta)[0], 'd/m/Y');
//
//                if (!$dadosPropostas->fk_reserva) {
//                    $infoReserva = FormularioCampoBotao::getBotaoPadrao(
//                        'criar-reserva',
//                        '<i class="fa fa-plus" aria-hidden="true"></i> Criar',
//                        '',
//                        null,
//                        'Clique aqui para criar uma nova reserva',
//                        'botao-criar-reserva'
//                    );
//                    if ($dias <= '0' || !$dadosPropostas->ativo) {
//                        $infoReserva->extras = 'disabled';
//                    }
//                    $infoReserva->setData('id', $dadosPropostas->id_proposta);
//                    $infoReserva->getHtml();
//                } else {
//                    $infoReserva = '<span title="Reserva nº ' . $dadosPropostas->fk_reserva . '"><i class="fa fa-check" aria-hidden="true"></i> nº ' . $dadosPropostas->fk_reserva . '</span>';
//                }
//
//                $infoPdf = FormularioCampoBotao::getBotaoPadrao(
//                    'gerar-pdf',
//                    '<i class="fa fa-download" aria-hidden="true"></i>',
//                    '',
//                    null,
//                    'Clique aqui para fazer o download',
//                    'botao-criar-pdf'
//                );
//                $infoPdf->setData('id', $dadosPropostas->id_proposta);
//                $infoPdf->getHtml();
//
//                $infoLink = FormularioCampoBotao::getBotaoPadrao(
//                    'gerar-link-encurtado',
//                    '<i class="fa fa-clipboard" aria-hidden="true"></i>',
//                    '',
//                    null,
//                    'Clique aqui para gerar o link encurtado',
//                    'botao-criar-link-encurtado'
//                );
//                $infoLink->setData('id', $dadosPropostas->id_proposta);
//                $infoLink->getHtml();
//
//                if ((bool)$dadosPropostas->ativo) {
//                    $status = FormularioCampoBotao::getBotaoPadrao(
//                        'plugveiculos_proposta_ativa',
//                        'Sim',
//                        null, 
//                        null, 
//                        "Clique para desativar a proposta."
//                    );
//                    $status->getTipoStatus(
//                        "desativarProposta(this, " . $dadosPropostas->id_proposta . ");",
//                        true
//                    );
//                } else {
//                    $status = FormularioCampoBotao::getBotaoPadrao(
//                        'plugveiculos_proposta_desativada',
//                        'Não',
//                        null,
//                        null,
//                        "Clique para ativar a proposta."
//                    );
//                    $status->getTipoStatus(
//                        "ativarProposta(this, " . $dadosPropostas->id_proposta . ");",
//                            false
//                    );
//                }
//
//                $LinhaNProposta = new VectorDev\AjaxTable\Cell($dadosPropostas->id_proposta);
//                $LinhaNProposta->addClass('dados-numero-proposta');
//                $LinhaLead = new VectorDev\AjaxTable\Cell($infoLead);
//                $LinhaVeiculo = new VectorDev\AjaxTable\Cell($dadosPropostas->nome_completo);
//                $LinhaDados = new VectorDev\AjaxTable\Cell(
//                    FormularioCampoBotao::getBotaoPadrao(
//                        'botao-ver',
//                        '<i class="fa fa-file-text-o"></i>',
//                        '',
//                        null,
//                        'Visualizar reserva',
//                        'botao-ver'
//                        )->setData('id', $dadosPropostas->id_proposta)->getHtml()
//                );
//                $LinhaDados->addClass('dados-visualizar-proposta');
//                $LinhaPdf = new VectorDev\AjaxTable\Cell($infoPdf.$infoLink);
//                $LinhaPdf->addClass('dados-download-pdf');
//                $LinhaReserva = new VectorDev\AjaxTable\Cell($infoReserva);
//                $LinhaReserva->addClass('dados-reservar-proposta');
//                $linhaValidade = new VectorDev\AjaxTable\Cell('<span title="' . $validade . '">' . $infoValidade . "</span>");
//                $linhaValidade->addClass('dados-vencimento-proposta' . (($infoValidade == 'Vencida') ? '-vencida' : ''));
//                $LinhaStatus = new VectorDev\AjaxTable\Cell($status->getHtml());
//                $Row = new VectorDev\AjaxTable\Row(
//                    $LinhaNProposta,
//                    $LinhaLead,
//                    $LinhaVeiculo,
//                    $LinhaDados,
//                    $LinhaPdf,
//                    $LinhaReserva,
//                    $linhaValidade,
//                    $LinhaStatus
//                );
//                $Response->addRow($Row);
//
//            }
//
//            $Response->returnRequest();
//
//            Util::exitJson(['sucesso' => true]);
//        } catch (ExcecaoPlugveiculos $e) {
//            Util::exitJson(['sucesso' => false, 'erro' => true]);
//        }
//        break;
//    case "ativar_proposta":
//        try {
//            $Proposta = new PlugveiculosPropostas($_GET["id_proposta"]);
//            $Proposta->ativo = true;
//            $Proposta->atualizar();
//
//            $btDesativar = FormularioCampoBotao::getBotaoPadrao('plugveiculos_proposta_ativa', 'sim', null, null, "Clique para desativar a proposta.")->getTipoStatus("desativarProposta(this, " . $_GET["id_proposta"] . ");", true);
//
//            Log::registrar(Log::TIPO_UPDATE, Log::plugveiculos("proposta", "ativar"), "Proposta ". $_GET["id_proposta"]." ativa");
//            Util::exitJson(['sucesso' => true, 'mensagem' => 'Proposta ativada com sucesso!', 'html_botao' => $btDesativar->getHtml()]);
//        } catch (ExcecaoPlugveiculos $x) {
//            Util::exitJson(['sucesso' => false, 'erro' => true, 'mensagem' => 'Erro ao ativar loja.']);
//        }
//        break;
//    case "desativar_proposta":
//        try {
//            $Proposta = new PlugveiculosPropostas($_GET["id_proposta"]);
//            $Proposta->ativo = false;
//            $Proposta->atualizar();
//            
//            $btDesativar = FormularioCampoBotao::getBotaoPadrao('plugveiculos_proposta_desativada', 'Não', null, null, "Clique para ativar a proposta.")->getTipoStatus("ativarProposta(this, " . $_GET["id_proposta"] . ");", false);
//
//            Log::registrar(Log::TIPO_UPDATE, Log::plugveiculos("proposta", "desativar"), "Proposta ". $_GET["id_proposta"]." desativada");
//            Util::exitJson(['sucesso' => true, 'mensagem' => 'Proposta desativada com sucesso!', 'html_botao' => $btDesativar->getHtml()]);
//        } catch (ExcecaoPlugveiculos $x) {
//            Util::exitJson(['sucesso' => false, 'erro' => true, 'mensagem' => 'Erro ao ativar loja.']);
//        }
//        break;
//    case "reservar":
//        try {
//            $idProposta = (int) $_GET['id_proposta'];
//
//            if (!$idProposta) {
//                Util::exitJson(['sucesso' => false, 'mensagem' => 'Não foi possível criar a reserva, tente novamente daqui a alguns minutos.']);
//            }
//            
//            $Proposta = new PlugveiculosPropostas($idProposta);
//            $Contato = new PlugveiculosLeadsContatos($Proposta->fk_lead);
//            $CarroLoja = new PlugveiculosCarrosLojas($Proposta->fk_veiculo);
//            $Carro = new PlugveiculosCarros($CarroLoja->fk_carro);
//            $Reserva = new PlugveiculosReservas();
//            $lojaCarro = $CarroLoja->getLoja()->id_loja;
//
//            $TempoAtendimento = new PlugveiculosLojas($lojaCarro);
//            $InfoDadosLead = 'Solicitação de reserva pela proposta de número ' . $Proposta->id_proposta;
//
//            if ($Carro->novo) {
//                $TipoLead = $CarroLoja->getLoja()->getReservaNovosTipoLead();
//                $valorAtendimento = $TempoAtendimento->getTempoRespostaReservaNovos();
//            } else {
//                $TipoLead = $CarroLoja->getLoja()->getReservaSeminovosTipoLead();
//                $valorAtendimento = $TempoAtendimento->getTempoRespostaReservaSeminovos();
//            }
//
//            ## Busca dados da promoção do veículo.
//            $promocaoAtiva = PlugveiculosCarrosPromocoes::buscaPromocaoAtiva($CarroLoja->id_carro_loja)[0];
//            ## Busca a quantidade de fotos do veículo.
//            $quantidadeFotos = PlugveiculosCarrosFotos::quantidadeFotos($CarroLoja->fk_carro)[0];
//            ## Monta o json referente a reserva.
//            $carroMetaData = PlugveiculosCarrosMetadata::buscar($CarroLoja->fk_carro)[0];
//
//            ## Monta as informações da reserva.
//            $DadosReserva = new PlugveiculosReservasCarros();
//            $DadosReserva->fk_combustivel = $Carro->fk_combustivel;
//            $DadosReserva->fk_situacao = $Carro->fk_situacao;
//            $DadosReserva->nome_completo = $carroMetaData->nome_completo;
//            $DadosReserva->ano_fabricacao = $Carro->ano_fabricacao;
//            $DadosReserva->valor = $CarroLoja->valor;
//            $DadosReserva->novo = $Carro->novo;
//            $DadosReserva->ordem = $Carro->ordem;
//            $DadosReserva->km = $CarroLoja->km;
//            $DadosReserva->descricao = $Carro->descricao;
//            $DadosReserva->observacoes = $CarroLoja->observacoes;
//            $DadosReserva->placa = $CarroLoja->placa;
//            $DadosReserva->cor = $CarroLoja->cor;
//            $DadosReserva->data_criacao = date('Y/m/d H:i:s');
//            $DadosReserva->data_alteracao = $Carro->data_alteracao;
//            if ($promocaoAtiva) {
//                $DadosReserva->promocao_valor = $promocaoAtiva->valor;
//                $DadosReserva->promocao_data_inicio = $promocaoAtiva->data_inicio;
//                $DadosReserva->promocao_data_final = $promocaoAtiva->data_final;
//            }
//            $DadosReserva->quantidade_fotos = (int) $quantidadeFotos->total;
//            $DadosReserva->lojaPreferencial = (int) $loja;
//
//            ## Efetua o cadastro da reserva.
//            $Reserva = new PlugveiculosReservas();
//            $Reserva->setCarro($CarroLoja);
//            $Reserva->setDadosCarro($DadosReserva);
//            $Reserva->setOrigem();
//            $Reserva->setStatus(PlugveiculosReservasStatus::getNovo());
//            $Reserva->setLeadContato($Contato);
//
//            $montaIntervado = array(
//                'P',
//                $valorAtendimento->dias.'D',
//                'T',
//                $valorAtendimento->horas.'H',
//                $valorAtendimento->minutos.'M'
//            );
//            $Data = new DateTime(date('Y/m/d H:i:s'));
//            $Data->add(new DateInterval(implode('', $montaIntervado)));
//            
//            # Método do Cron modificado para receber Null.
//            $Reserva->setCron(null);
//            # Adiciona a Reserva.
//            $Reserva->adicionar();
//            # Vincula o ID da Reserva criado na proposta.
//            $Proposta->setReserva(new PlugveiculosReservas($Reserva->id_reserva));
//            $Proposta->atualizar();
//
//            ## Efetua o evento do lead.
//            $Evento = new PlugveiculosLeadsHistorico();
//            $Evento->setTipoLead($TipoLead);
//            $Evento->setLeadContato($Contato);
//            $Evento->setReserva($Reserva);
//            $Evento->dados = $InfoDadosLead;
//            $Evento->adicionar();
//
//            ## Cadastra as informações ao RDStation, caso esteja ativado.
//            if (RDStation::rdstationAtivo()) {
//                
//                if(defined('PLUGVEICULOS_BASE_REMOTA')) {
//                    $origem = (PLUGVEICULOS_BASE_REMOTA) ? PlugveiculosReservas::ORIGEM_EXTERNA : PlugveiculosReservas::ORIGEM_INTERNA;
//                } else {
//                    $origem = PlugveiculosReservas::ORIGEM_INTERNA;
//                }
//                
//                $NomeLoja = new PlugveiculosLojas($CarroLoja->fk_loja);
//                $dados_complementares['Nome'] = $Contato->nome;
//                $dados_complementares['Telefone'] = ($Contato->celular) ? $Contato->celular : 'Não Informado';
//                $dados_complementares['Veículo'] = $carroMetaData->nome_completo;
//                $dados_complementares['Valor'] = (($promocaoAtiva) ? Util::moneyToFloat($promocaoAtiva->valor) : Util::moneyToFloat($CarroLoja->valor));
//                $dados_complementares['Tipo'] = ($Carro->novo) ? 'Novo' : 'Seminovo';
//                $dados_complementares['Origem'] = $origem;
//                $dados_complementares['Fabricante'] = $carroMetaData->marca;
//                $dados_complementares['Concessionária'] = $NomeLoja->Concessionaria->nome . ' ' . $NomeLoja->nome;
//                $dados_complementares['identificador'] = 'reserva-plugcar';
//
//                $RDStation = new RDStation($Contato->email, $dados_complementares);
//                $RDStation->enviarDados();
//            }
//
//            ## Cadastra as informações a ByMotos, caso esteja ativado.
//            if (ContatoByMotos::ByMotosAtivo() && $Contato->cpf) {   
//                
//                $NomeLoja = new PlugveiculosLojas($CarroLoja->fk_loja);
//                $ContatoByMotos = new ContatoByMotos();
//                
//                $dadosContatos = [];
//                $dadosContatos[] = 'Nome: '.$Contato->nome.' -';
//                $dadosContatos[] = 'E-mail: '.$Contato->email.' -';
//                $dadosContatos[] = 'CPF: '.$Contato->cpf.' -';
//                if($leadCelular){
//                    $dadosContatos[] = 'Celular: '.$Contato->celular.' -';
//                }
//                $dadosContatos[] = 'Unidade: '.$NomeLoja->nome.' -';
//                $dadosContatos[] = 'Modelo '.$carroMetaData->nome_completo.' -';
//                $dadosContatos[] = 'Mensagem: Proposta - Reserva criada utilizando o sistema de Proposta';
//                
//                $ContatoByMotos->setCidade("");
//                $ContatoByMotos->setEmail($Contato->email);
//                $ContatoByMotos->setMensagem(implode(' ', $dadosContatos));
//                ## O modelo é opcional, quando for enviado o modelo será gravado o interesse
//                $ContatoByMotos->setModelo($carroMetaData->nome_completo);
//                $ContatoByMotos->setNome($Contato->nome);
//                $ContatoByMotos->setDdd(substr($Contato->celular,0,-9)?substr($Contato->celular,0,-9):'00');
//                $ContatoByMotos->setTelefone(substr($Contato->celular,2)?substr($Contato->celular,2):'000000000');
//                if (defined("BYMOTOS_UNIDADE")) { 
//                    $ContatoByMotos->setUnidade(strtoupper(BYMOTOS_UNIDADE));
//                } else {
//                    $ContatoByMotos->setUnidade(strtoupper($NomeLoja->nome));
//                }
//                $ContatoByMotos->enviar();
//            }
//            
//            ## Cadastra as informações no sistema do myHonda, caso esteja ativado.
//            if (defined("PLUGVEICULOS_MYHONDA_CODIGO_CONCESSIONARIA")) {
//
//                $url = 'https://login.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
//
//                $data = array(
//                    'first_name' => $Contato->nome,
//                    'last_name' => $Contato->sobrenome,
//                    'mobile' => $Contato->celular,
//                    'email' => $Contato->email,
//                    'cpf__c' => $Contato->cpf,
//                    'Campaign_ID' => '',
//                    'model_interest__c' => $carroMetaData->modelo . ' ' . $carroMetaData->versao,
//                    'type__c' => 'HDA',
//                    'lead_source' => 'WebSite Concessionária',
//                    'sub_source_media__c' => 'Site',
//                    'opt_in_email__c' => false,
//                    'opt_in_phone__c' => false,
//                    'dealer_code_interest__c' => PLUGVEICULOS_MYHONDA_CODIGO_CONCESSIONARIA,
//                    'oid' => '00D61000000HSuF',
//                    'retURL' => $_SERVER['HTTP_HOST']
//                );
//
//                $dataString = '';
//                foreach($data as $chave => $valor) {
//                    $dataString .= $chave . '=' . $valor . '&';
//                }
//                $dataString = rtrim($dataString,'&');
//
//                $ch = curl_init();
//                curl_setopt($ch,CURLOPT_URL,$url);
//                curl_setopt($ch,CURLOPT_POST,count($data));
//                curl_setopt($ch,CURLOPT_POSTFIELDS,$dataString);
//                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
//                curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
//                curl_setopt($ch,CURLOPT_FOLLOWLOCATION, TRUE);
//                curl_exec($ch);
//                $CodigoResposta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//                curl_close($ch);
//                
//                if ($CodigoResposta =! 200) {
//                    try {
//                        throw new ExcecaoPlugdados('ATENÇÃO: Erro silencioso, por favor verifique as configurações do myHonda', ERRO_PLUGDADOS, debug_backtrace());
//                    }catch (Excecao $r) {
//                        // nada a fazer
//                    }
//                }   
//            }
//            ## Envia um e-mail para o(s) vendedore(s) cadastrado informado a reserva.
//            $Reserva->notificarNovaReservaUsuarios();
//            ## Envia um e-mail para o usuário sobre sua reserva.
//            $Reserva->notificarNovaReservaLeadContato();
//
//            Log::registrar(Log::TIPO_INSERT, Log::plugveiculos("proposta", "inserir"), "Inclusão da proposta. ID: ". $_GET["id_proposta"]);
//            Util::exitJson(["sucesso" => true, "mensagem" => "Reserva criada com sucesso!"]);
//        } catch(Excecao $e) {
//            Util::exitJson(["sucesso" => false]);
//        }
//        break;
//    case 'visualizar_proposta':
//        try {
//            $propostas = PlugveiculosPropostas::buscar(null, $_GET['id_proposta'])[0];
//
//            $html = [];
//            $html[] = 'Lead / Contato: <span class="modal-ver-dados">'.$propostas->nome. ' &#60;' . $propostas->email . '&#62;</span>';
//            $html[] = 'Tipo: <span class="modal-ver-dados">'  . (($propostas->tipo_veiculo === PlugveiculosCarros::VEICULONOVO) ? 'Veículo Novo' : 'Veículo Seminovo') . '</span>';
//            $html[] = 'Concessionária: <span class="modal-ver-dados">' . $propostas->nome_loja . '</span>';
//            $html[] = 'Veículo: <span class="modal-ver-dados">' . $propostas->nome_completo . '</span>';
//            $html[] = 'Valor:  <span class="modal-ver-dados">' . ($propostas->valor_carro_loja ? 'R$ ' . Util::floatToMoney($propostas->valor_carro_loja) : 'Valor não definido' ) . '</span>';
//            $html[] = 'Cor: <span class="modal-ver-dados">' . ($propostas->cor ? $propostas->cor : 'Não definida') . '</span>';
//            $html[] = 'Observações: <span class="modal-ver-dados">' . ($propostas->observacoes ? $propostas->observacoes : 'Sem observação') . '</span>';
//
//            if ((bool)$propostas->valor_entrada) {
//                $html[] = '<br /><span class="modal-ver-dados">Financiamento</span>';
//                $html[] = 'Valor da entrada: <span class="modal-ver-dados"> R$ ' . Util::floatToMoney((float)$propostas->valor_entrada) . '</span>';
//                $html[] = 'Número de parcelas: <span class="modal-ver-dados">' . $propostas->numero_parcelas . ' vezes</span>';
//                $html[] = 'Valor financiado: <span class="modal-ver-dados">R$ ' . Util::floatToMoney((float)$propostas->valor_financiado) . '</span>';
//            }
//            if ((bool)$propostas->nome_plano) {
//                $html[] = '<br /><span class="modal-ver-dados">Consórcio</span>';
//                $html[] = 'Nome do plano: <span class="modal-ver-dados">' . $propostas->nome_plano . '</span>';
//                $html[] = 'Número de parcelas: <span class="modal-ver-dados">' . $propostas->numero_parcelas_consorcio . ' vezes</span>';
//                $html[] = 'Valor da parcela: <span class="modal-ver-dados">R$ ' . Util::floatToMoney((float)$propostas->valor_parcela) . '</span>';
//            }
//
//            Util::exitJson(['sucesso' => true, 'html' => implode('<br/>', $html)]);
//        } catch (ExcecaoPlugveiculos $e) {
//            Util::exitJson(['retorno' => 'erro', 'mensagem' => 'Ocorreu um erro durante a inclusão do tipo de lead e a vector receberá um relatório sobre o problema.']);
//        }
//        break;
//    case 'encurtar_url':
//        try {
//            $idProposta = $_GET['id_proposta'];
//            $montaUrl = URL_ARQUIVOS . 'plugveiculos/propostas/proposta-' . $idProposta . '.pdf';
//            $urlEncurtada = Util::getShortUrl($montaUrl);
//
//            Util::exitJson(['sucesso' => true, 'html' => $urlEncurtada, 'mensagem' => 'URL gerada com sucesso!']);
//        } catch (ExcecaoPlugveiculos $e) {
//            Util::exitJson(['retorno' => 'erro', 'mensagem' => 'Ocorreu um erro durante a inclusão do tipo de lead e a vector receberá um relatório sobre o problema.']);
//        }
//        break;
//}
//
//$TodosLeadsContatos = PlugveiculosLeadsContatos::buscar(null, ['email', 'ASC']);
//
//$TodasLojas = PlugveiculosLojas::getConcessionariasLojas(['nome_completo', 'ASC']);
//$Usuario = PlugveiculosUsuario::getUsuarioAutenticado();
//$todas_lojas_privilegios = $Usuario->getLojasComPrivilegio(
//    new PlugveiculosLojasPrivilegios(PlugveiculosLojasPrivilegios::PRIVILEGIO_ESTOQUE)
//);
//
//# Filtro
//$SelectFiltroLeadsContatos = new FormularioCampoSelect('filtro_lead', 'Filtrar por Lead', false);
//$SelectFiltroLeadsContatos->id = 'filtro-lista-lead';
//$SelectFiltroLeadsContatos->class_span = 'box-filtro-lista-lead';
//$SelectFiltroLeadsContatos->addItem('', 'Lead / Cliente');
//foreach ($TodosLeadsContatos as $Contato) {
//    $SelectFiltroLeadsContatos->addItem($Contato->id_lead, $Contato->nome ? $Contato->nome.' <'.$Contato->email.'>' : $Contato->email);
//}
//
//$SelectFiltroTipoVeiculo = new FormularioCampoSelect('filtro_tipo_veiculo', 'Filtrar por Tipo', false);
//$SelectFiltroTipoVeiculo->id = 'filtro-tipo-veiculo';
//$SelectFiltroTipoVeiculo->class_span = 'box-filtro-tipo-veiculo';
//$SelectFiltroTipoVeiculo->addItem('', 'Selecione um tipo');
//$SelectFiltroTipoVeiculo->addItem(PlugveiculosCarros::VEICULONOVO, 'Veículos novos');
//$SelectFiltroTipoVeiculo->addItem(PlugveiculosCarros::VEICULOSEMINOVO, 'Veículos seminovos');
//
//$SelectFiltroTodasLojas = new FormularioCampoSelect('filtro_loja', 'Filtrar por Loja', false);
//$SelectFiltroTodasLojas->id = 'filtro-loja';
//$SelectFiltroTodasLojas->class_span = 'box-filtro-lojas-select';
//$SelectFiltroTodasLojas->addItem('', 'Selecione uma loja', true);
//foreach ($TodasLojas as $Lojas) {
//    $nome_part = [];
//    if (!$Lojas->status) {
//        $nome_part[] = 'Inativo';
//    }
//    if (!in_array($Lojas->id_loja, $todas_lojas_privilegios)) {
//        $nome_part[] = 'Sem privilégio';
//    }
//
//    $SelectFiltroTodasLojas->addItem(
//        $Lojas->id_loja,
//        $Lojas->nome_completo.($nome_part ? ' ('.implode(', ', $nome_part).')' : ''),
//        false,
//        !in_array($Lojas->id_loja, $todas_lojas_privilegios)
//    );
//}
//
//# Cadastro
//$SelectLeadsContatos = new FormularioCampoSelect('lead', 'Lead', true);
//$SelectLeadsContatos->id = 'lista-lead';
//$SelectLeadsContatos->class_span = 'box-lista-lead';
//$SelectLeadsContatos->addItem('', 'Selecione um Lead / Cliente');
//foreach ($TodosLeadsContatos as $Contato) {
//    $SelectLeadsContatos->addItem($Contato->id_lead, $Contato->nome ? $Contato->nome.' <'.$Contato->email.'>' : $Contato->email);
//}
//
//$SelectTipoVeiculo = new FormularioCampoSelect('tipo_veiculo', 'Tipo', false);
//$SelectTipoVeiculo->id = 'tipo-veiculo';
//$SelectTipoVeiculo->class_span = 'box-tipo-veiculo';
//$SelectTipoVeiculo->addItem(PlugveiculosCarros::VEICULONOVO, 'Veículos novos');
//$SelectTipoVeiculo->addItem(PlugveiculosCarros::VEICULOSEMINOVO, 'Veículos seminovos');
//
//$SelectTodasLojas = new FormularioCampoSelect('loja', 'Loja', true);
//$SelectTodasLojas->id = 'loja';
//$SelectTodasLojas->class_span = 'box-lojas-select';
//$SelectTodasLojas->addItem('', 'Selecione uma loja', true);
//foreach ($TodasLojas as $Lojas) {
//    $nome_part = [];
//    if (!$Lojas->status) {
//        $nome_part[] = 'Inativo';
//    }
//    if (!in_array($Lojas->id_loja, $todas_lojas_privilegios)) {
//        $nome_part[] = 'Sem privilégio';
//    }
//
//    $SelectTodasLojas->addItem(
//        $Lojas->id_loja,
//        $Lojas->nome_completo.($nome_part ? ' ('.implode(', ', $nome_part).')' : ''),
//        false,
//        !in_array($Lojas->id_loja, $todas_lojas_privilegios)
//    );
//}
//
//$SelectFiltroVeiculos = new FormularioCampoSelect('veiculos', 'Veículos', true);
//$SelectFiltroVeiculos->id = 'veiculos';
//$SelectFiltroVeiculos->class_span = 'box-veiculos-select';
//$SelectFiltroVeiculos->addItem('', 'Para exibir os veículos, selecione primeiro uma loja');
        }  
    }
    public function getHtml()
    {
        try
        {
            /*
             * Cabeçalho
             */
            require PATH_RAIZ . '/visualizacoes/incluir/menu.php';

            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/relatorio.php';

            /*
             * Rodapé
             */
            require PATH_RAIZ . '/visualizacoes/incluir/rodape.php';
        }
        catch (Exception $ex)
        {
            echo 'Exceção: ',  $ex->getMessage(), "\n";
        }
		
    }

}
