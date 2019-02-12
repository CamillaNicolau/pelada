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
                    $html = [];
                    $buscaPeladaPeladeiro = PeladaRepositorio::buscaGeralPelada(['p.fk_pelada = '.$_POST['id_pelada'].' and p.confirmacao = 1']);
                    foreach($buscaPeladaPeladeiro as $peladaPeladeiro) {
                        $html[] =  array('id'=>$peladaPeladeiro->fk_peladeiro,'nome'=>$peladaPeladeiro->nome,'status'=>$peladaPeladeiro->status_pagamento) ;
                    }
                    exit(json_encode(array('sucesso'=>true,'html'=>$html)));
                }catch(Erro $E){
                  exit(json_encode(array('sucesso'=>false, "mensagem" => "Desculpe, Ocorreu um erro ao carregar lista de peladeiro.")));
                }
            break;
            
            case 'info_pagamento':
                try{
                    $html = [];
                    $dadosPagamento = FinanceiroRepositorio::buscarLancamento(['u.id_usuario='.$_POST['id_peladeiro']]);
                    foreach ($dadosPagamento as $pagamento){
                        $html[] = array('id'=>$pagamento->id_lancamento,'diaria'=>$pagamento->diaria,'mensalidade'=>$pagamento->mensalidade,'status'=>$pagamento->participacao);
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
                    $buscarLancamentoPeladeiro = FinanceiroRepositorio::dadosLancamento(['fk_peladeiro='. $_POST['id_peladeiro']]);
                    \Doctrine::beginTransaction();
                    if(count($buscarLancamentoPeladeiro) > 0){
                        if($buscarLancamentoPeladeiro[0]->status_pagamento == "Débito"){
                            $lacamentos['fp'] = $buscarLancamentoPeladeiro[0]->id_financeiro_peladeiro;
                            $lacamentos['valor_pago'] = $_POST['valorPagamento'];
                            if($_POST['valorPagamento'] < $_POST['pagamentoReal']){
                                $lacamentos['status'] = 'Débito';
                            } else if($_POST['valorPagamento'] > $_POST['pagamentoReal']){
                                $lacamentos['status'] = 'Crédito';
                            } else{
                                $lacamentos['status'] = 'Zerado';
                            }
                        }
                        $FinanceiroRepositorio->atualizarPeladeiroPagamento($lacamentos);
                        \Doctrine::commit();
                        exit(json_encode(array('sucesso'=>true,'mensagem'=>'Dados atualizados com sucessos')));   
                    }
                    \Doctrine::beginTransaction();

                    
                    $lacamentos['peladeiro'] = $_POST['id_peladeiro'];
                    $lacamentos['financeiro'] = $_POST['id_financeiro'];
                    $lacamentos['valor_pago'] = $_POST['valorPagamento'];
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
