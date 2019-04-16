<?php

/**
 * Gerencia a exibição da página inicial.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class FinanceiroControle extends ControlaModelos
{

    public function tratarAcoes()
    {
     
        if(isset($_REQUEST['acao']));
        switch ($_REQUEST['acao'])
        {
        	case 'adicionar':
            try
            {            
                \Doctrine::beginTransaction();

                $pelada = $_POST['pelada'];
               
                $FinanceiroRepositorio = new FinanceiroRepositorio();
                $Financeiro = new Financeiro();

                $Financeiro->setPelada(new Pelada($pelada));
                $Financeiro->valorMensalista = (float)$_POST['valorMensalista'];
                $Financeiro->valorDiarista = (float)$_POST['valorDiaria'];
                $Financeiro->valorPelada = (float)$_POST['valorTotal'];
                $Financeiro->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                $FinanceiroRepositorio->adicionaLancamento($Financeiro);
                \Doctrine::commit();
                exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));   
            } catch (Erro $E) {
              \Doctrine::rollBack();
              exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar')));
            }
            break;

            case 'buscar_dados':
                try{
                    $Financeiro = new Financeiro($_POST['id_lancamento']);
                    if($Financeiro->pelada){
                        $Pelada = new Pelada($Financeiro->pelada);
                    }
                    $saida = array();

                    $saida['idLancamento'] = $Financeiro->idLancamento;
                    $saida['mensalidade'] = $Financeiro->valorMensalista;
                    $saida['diaria'] = $Financeiro->valorDiarista;
                    $saida['totalPelada'] = $Financeiro->valorPelada;
                    $saida['pelada'] = $Financeiro->pelada;


                    exit(json_encode($saida));
                }catch(Erro $E){
                    exit(json_encode(array('sucesso'=>false)));
                }
            break;

            case 'atualizar':
                try{
                  
                    \Doctrine::beginTransaction();
                    
                    $pelada = $_POST['pelada'];
                   
                    $FinanceiroRepositorio = new FinanceiroRepositorio();
                    $Financeiro = new Financeiro($_POST['id_lancamento']);

                    $Financeiro->setPelada(new Pelada($pelada));
                    $Financeiro->valorMensalista = (float)$_POST['valorMensalista'];
                    $Financeiro->valorDiarista = (float)$_POST['valorDiaria'];
                    $Financeiro->valorPelada = (float)$_POST['valorTotal'];
                    $Financeiro->setUsuario(new Usuario($_SESSION['id_usuario_logado']));

                    $FinanceiroRepositorio->atualizarLancamento($Financeiro);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados alterados com sucessos')));
                      
                } catch (Erro $E) {
                \Doctrine::rollBack();
                 exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao atualizar dados da pelada')));
                }
            break;

            case 'remover_lancamento':
                try{

                    \Doctrine::beginTransaction();
                    $FinanceiroRepositorio = new FinanceiroRepositorio();
                    $Financeiro = new Financeiro($_POST['id_lancamento']);
              
                    $FinanceiroRepositorio->deletarLancamento($Financeiro);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Lançamento removido com sucessos')));
                    
                } catch(Erro $E){
                    \Doctrine::rollBack();
                   exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao remover lançamento')));
                }
            break;

        	case 'busca_pelada':
                try{

                    $html = [];
                    $ListaPelada = PeladaRepositorio::buscarPelada(['p.fk_peladeiro ='.$_SESSION['id_usuario_logado'].' and status <> "encerrada"']);
                    foreach($ListaPelada as $pelada) {
                        $html[] =  array('id'=>$pelada->id_pelada,'nome'=>$pelada->nome_pelada) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de pelada.")));
                }
            break;

            case 'lista_lancamento':
                try{

                    $html = [];
                    $ListaLancamento = FinanceiroRepositorio::buscarLancamento(['f.fk_peladeiro ='.$_SESSION['id_usuario_logado']]);
                    foreach($ListaLancamento as $lancamento) {
                        $html[] =  array('id'=>$lancamento->id_lancamento,'nome'=>$lancamento->nome_pelada,'total'=>$lancamento->total_pelada, 'pelada'=>$lancamento->id_pelada) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de pelada.")));
                }
            break;

            case 'buscar_peladeiro':
                try{
                    
                    $buscaPeladaPeladeiro = FinanceiroRepositorio::buscarPeladeiroInfoConfirmado(['pe.fk_pelada = '.$_POST['id_pelada'].' and pe.confirmacao = 1']);
                    $html = [];
                    foreach($buscaPeladaPeladeiro as $peladaPeladeiro) {
                        $buscaLancamentoPeladeiro = FinanceiroRepositorio::buscarPeladeiroLancamento(['fp.fk_peladeiro = '.$peladaPeladeiro->id_usuario]);
                        if(count($buscaLancamentoPeladeiro) > 0){
                            foreach ($buscaLancamentoPeladeiro as $lacamentoPeladeiro) {
                                $status  =$lacamentoPeladeiro->status_pagamento;
                                $html[] =  array('id'=>$peladaPeladeiro->id_usuario,'nome'=>$peladaPeladeiro->nome,'status'=>$status) ;
                            }
                        } else {
                            $html[] =  array('id'=>$peladaPeladeiro->id_usuario,'nome'=>$peladaPeladeiro->nome,'status'=>"") ;
                        }  
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de peladeiro.")));
                }
            break;
            
            case 'info_pagamento':
                try{
                    $html = [];
                    $dadosPagamento = FinanceiroRepositorio::buscarPeladeiroInfoConfirmado(['pe.confirmacao = 1 and u.id_usuario='.$_POST['id_peladeiro']]);
                    for($i=0;$i<count($dadosPagamento);$i++){
                        $buscaLancamentoPeladeiro = FinanceiroRepositorio::buscarPeladeiroLancamento(['fp.fk_peladeiro = '.$dadosPagamento[$i]->id_usuario]);
                        if(count($buscaLancamentoPeladeiro) > 0){
                            foreach ($buscaLancamentoPeladeiro as $lacamentoPeladeiro) {
                                $valor_pago  =$lacamentoPeladeiro->valor_pago;
                                $id_lancamento_peladeiro = $lacamentoPeladeiro->id_financeiro_peladeiro;
                                $html[] = array('id'=>$dadosPagamento[$i]->id_lancamento,'diaria'=>$dadosPagamento[$i]->diaria,'mensalidade'=>$dadosPagamento[$i]->mensalidade,'status'=>$dadosPagamento[$i]->participacao,'pagamento'=>$valor_pago,'lancamento_peladeiro'=>$id_lancamento_peladeiro);
                            }
                        } else {
                            $html[] = array('id'=>$dadosPagamento[$i]->id_lancamento,'diaria'=>$dadosPagamento[$i]->diaria,'mensalidade'=>$dadosPagamento[$i]->mensalidade,'status'=>$dadosPagamento[$i]->participacao,'pagamento'=>'0','lancamento_peladeiro'=>"");
                        }
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar os dados.")));
                }
            break;
        
            case 'adicionar_lancamento':
                try{
                    $lacamentos = [];
                    $FinanceiroRepositorio = new FinanceiroRepositorio();
                    
                    \Doctrine::beginTransaction();

                    $lacamentos['peladeiro'] = (int)$_POST['id_peladeiro'];
                    $lacamentos['financeiro'] = (int)$_POST['id_financeiro'];
                    $lacamentos['valor_pago'] = (float)$_POST['valorPagamento'];
                    if($_POST['valorPagamento'] < $_POST['pagamentoReal']){
                        $lacamentos['status'] = 'Débito';
                    } else if($_POST['valorPagamento'] > $_POST['pagamentoReal']){
                        $lacamentos['status'] = 'Crédito';
                    } else{
                        $lacamentos['status'] = 'Zerado';
                    }

                    $FinanceiroRepositorio->salvarPeladeiroPagamento($lacamentos);
                    \Doctrine::commit();
                   
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados adicionados com sucessos')));   
                } catch (Erro $E) {
                  \Doctrine::rollBack();
                  exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar')));
                }
            break;

            case 'atualiza_lancamento':
                try{
                    $lacamentos = [];
                    $FinanceiroRepositorio = new FinanceiroRepositorio();
                    $buscarLancamentoPeladeiro = FinanceiroRepositorio::dadosLancamento(['fp.fk_peladeiro='. $_POST['id_peladeiro']]);
                    \Doctrine::beginTransaction();

                    $lacamentos['fp'] = $buscarLancamentoPeladeiro[0]->id_financeiro_peladeiro;
                    $lacamentos['valor_pago'] = $_POST['valorPagamento'];

                    switch ($buscarLancamentoPeladeiro[0]->participacao) {
                        case 'mensalista':
                            if($lacamentos['valor_pago'] < $buscarLancamentoPeladeiro[0]->mensalidade){
                                $lacamentos['status'] = 'Débito';
                            } else if($lacamentos['valor_pago'] > $buscarLancamentoPeladeiro[0]->mensalidade){
                                $lacamentos['status'] = 'Crédito';
                            } else{
                                $lacamentos['status'] = 'Zerado';
                            }
                            break;
                        case 'diarista':
                            if($_POST['valor_pago'] < $buscarLancamentoPeladeiro[0]->diaria){
                                $lacamentos['status'] = 'Débito';
                            } else if($lacamentos['valor_pago'] > $buscarLancamentoPeladeiro[0]->diaria){
                                $lacamentos['status'] = 'Crédito';
                            } else{
                                $lacamentos['status'] = 'Zerado';
                            }
                        break;
                    }
                    
                    $FinanceiroRepositorio->atualizarPeladeiroPagamento($lacamentos);
                    \Doctrine::commit();
                    exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados atualizados com sucessos')));   

                }catch (Erro $E) {
                  \Doctrine::rollBack();
                  exit(json_encode(array('sucesso'=>false,'mensagem'=>'Erro ao cadastrar')));
                }
            break;

            case 'fluxo_pagamento':
                try{
                    $html = [];

                        $buscaFluxoCaixa = FinanceiroRepositorio::dadosLancamento(['f.id_lancamento = '.$_POST['id_lancamento']]);
                        var_dump($buscaFluxoCaixa);
                    //     if(count($buscaLancamentoPeladeiro) > 0){
                    //         foreach ($buscaLancamentoPeladeiro as $lacamentoPeladeiro) {
                    //             $valor_pago  =$lacamentoPeladeiro->valor_pago;
                    //             $id_lancamento_peladeiro = $lacamentoPeladeiro->id_financeiro_peladeiro;
                    //             $html[] = array('id'=>$dadosPagamento[$i]->id_lancamento,'diaria'=>$dadosPagamento[$i]->diaria,'mensalidade'=>$dadosPagamento[$i]->mensalidade,'status'=>$dadosPagamento[$i]->participacao,'pagamento'=>$valor_pago,'lancamento_peladeiro'=>$id_lancamento_peladeiro);
                    //         }
                    //     } else {
                    //         $html[] = array('id'=>$dadosPagamento[$i]->id_lancamento,'diaria'=>$dadosPagamento[$i]->diaria,'mensalidade'=>$dadosPagamento[$i]->mensalidade,'status'=>$dadosPagamento[$i]->participacao,'pagamento'=>'0','lancamento_peladeiro'=>"");
                    //     }
                    // }

               
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar os dados.")));
                }
            break;
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
             * Carrega o modelo da página
             */
          
            /*
             * Conteúdo da Index
             */
            require PATH_RAIZ . '/visualizacoes/financeiro.php';

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
