<?php

/**
 * Gerenciar os dados a serem enviados e recebidos do banco
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019 
 */
class FinanceiroRepositorio extends Financeiro {
   
    /**
     * Adicionar as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @return boolean
    */
    public function adicionaLancamento(Financeiro $Financeiro) {

        if($Financeiro->idLancamento){
           echo("Método adicionaLancamento() utilizado em objeto que já é instância de usuário válido.");
        } 
        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder(); 
            $QueryBuilder
                ->insert('financeiro')
                ->setValue('mensalidade', ':mensalidade')
                ->setValue('diaria', ':diaria')
                ->setValue('total_pelada', ':total_pelada')
                ->setValue('fk_peladeiro', ':fk_peladeiro')
                ->setValue('fk_pelada', ':fk_pelada')
                ->setValue('data_criacao', ':data_criacao')
                ->setParameter(':mensalidade', $Financeiro->valorMensalista)
                ->setParameter(':diaria', $Financeiro->valorDiarista)
                ->setParameter(':total_pelada', $Financeiro->valorPelada)
                ->setParameter(':fk_peladeiro', $Financeiro->peladeiro)
                ->setParameter(':fk_pelada', $Financeiro->pelada)
                ->setParameter(':data_criacao', $Financeiro->dataCriacao)
                ->execute()
            ; 
            $Financeiro->idLancamento = $QueryBuilder->getConnection()->lastInsertId();
            return $Financeiro->idLancamento;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Lançamentos Financeiros" . $ex);
        }   
    }
    
    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     * 
     * @param array $condicoes
     * @param type $order
     * @param type $inicio
     * @param type $limite
     * @return array
     */
    public static function buscarLancamento(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('financeiro' ,'f')
                ->join('f','pelada','p','f.fk_pelada = p.id_pelada')
                ->join('f','usuario','u','f.fk_peladeiro = u.id_usuario')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao buscar Lançamentos Financeiros". $j->getMessage());
        }
    }

    /**
     * Atualiza os dados do objeto no banco de dados.
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function atualizarLancamento(Financeiro $Financeiro)
    {
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('financeiro')
                ->set('mensalidade', ':mensalidade')
                ->set('diaria', ':diaria')
                ->set('total_pelada', ':total_pelada')
                ->set('fk_peladeiro', ':fk_peladeiro')
                ->set('fk_pelada', ':fk_pelada')
                ->setParameter(':mensalidade', $Financeiro->valorMensalista)
                ->setParameter(':diaria', $Financeiro->valorDiarista)
                ->setParameter(':total_pelada', $Financeiro->valorPelada)
                ->setParameter(':fk_peladeiro', $Financeiro->peladeiro)
                ->setParameter(':fk_pelada', $Financeiro->pelada)
                ->where('id_lancamento = :id_lancamento')
                ->setParameter(':id_lancamento', $Financeiro->idLancamento)
                ->execute()
            ;
            return true;
        } catch (\Exception $j) {
            echo("Erro ao atualizar os Lançamentos Financeiros- " . $j->getMessage());
        }
    }

    /**
     * Deleta o registro no banco de dados .
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function deletarLancamento(Financeiro $Financeiro) {
        
        if (!$Financeiro->idLancamento) {
            echo('Tentativa de deletar do banco de dados um registro inexistente.');
        }
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->delete('financeiro')
                ->where('id_lancamento = :id_lancamento')
                ->setParameter(':id_lancamento', $Financeiro->idLancamento)
                ->execute()
            ; 
        } catch (\Exception $j) {
            echo($j->getMessage());
        }
       return true;
    }
    
    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     * 
     * @param array $condicoes
     * @param type $order
     * @param type $inicio
     * @param type $limite
     * @return array
     */
    public static function dadosLancamento(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('financeiro_peladeiro','fp')
                ->join('fp','financeiro','f','f.id_lancamento = fp.fk_financeiro')
                ->join('fp','usuario','u','fp.fk_peladeiro = u.id_usuario')
               
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao buscar Lançamentos Financeiros". $j->getMessage());
        }
    }
    
    /**
     * Salva os pagamentos dos peladeiros.
     *
     * @return bool
     */
    public function salvarPeladeiroPagamento($lancamento){

        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->insert('financeiro_peladeiro')
                ->setValue('fk_peladeiro', ':fk_peladeiro')
                ->setValue('fk_financeiro', ':fk_financeiro')
                ->setValue('valor_pago', ':valor_pago')
                ->setValue('status_pagamento', ':status_pagamento')
                ->setValue('observacao', ':observacao')
                ->setParameter(':fk_peladeiro', $lancamento['peladeiro'])
                ->setParameter(':fk_financeiro', $lancamento['financeiro'])
                ->setParameter(':valor_pago',$lancamento['valor_pago'])
                ->setParameter(':status_pagamento', $lancamento['status'])
                ->setParameter(':observacao', $lancamento['observacao'])
                ->setParameter(':data_criacao ', date("Y-m-d H:i:s"))
                ->execute()
            ;
            return $QueryBuilder->getSQL();
        } catch (\Exception $j) {
            echo("Erro ao inserir peladeiro aos Lançamentos Financeiros- " . $j->getMessage());
        }
    }

    /**
     * Atualiza os dados do objeto no banco de dados.
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function atualizarPeladeiroPagamento($lancamento){
      try {
        $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
        $QueryBuilder
            ->update('financeiro_peladeiro')
            ->set('valor_pago', ':valor_pago')
            ->set('status_pagamento', ':status_pagamento')
            ->set('observacao', ':observacao')
            ->setParameter(':valor_pago',$lancamento['valor_pago'])
            ->setParameter(':status_pagamento', $lancamento['status'])
            ->setParameter(':observacao', $lancamento['observacao'])
            ->where('id_financeiro_peladeiro = :id_financeiro_peladeiro')
            ->setParameter(':id_financeiro_peladeiro', $lancamento['fp'])
            ->execute()
            ;

      } catch (\Exception $e26811) {
          echo('Erro ao atualizar na classe '.__CLASS__.': '.$e26811->getMessage());
      }
      return true;
    }
    
    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     *
     * @param int $fk_carro_loja
     * @param array $order
     * @param array $limit
     * @return array
     */
    public static function buscarPeladeiroInfoConfirmado(array $condicoes = []){
      $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('usuario','u')
                ->join('u','pelada_peladeiro','pe','pe.fk_peladeiro = u.id_usuario')
                ->join('pe','pelada','p','p.id_pelada = pe.fk_pelada')
                ->join('p','financeiro','f','f.fk_pelada = p.id_pelada')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            return $QueryBuilder->execute()->fetchAll();
        }

        catch (\Exception $j) {
            echo ("Erro ao buscar Peladeiros". $j->getMessage());
        }
    }

    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     *
     * @param int $fk_carro_loja
     * @param array $order
     * @param array $limit
     * @return array
     */
    public static function buscarPeladeiroLancamento(array $condicoes = []){
      $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('usuario','u')
                ->join('u','financeiro_peladeiro','fp','fp.fk_peladeiro = u.id_usuario')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            return $QueryBuilder->execute()->fetchAll();
        }

        catch (\Exception $j) {
            echo ("Erro ao buscar Peladeiros". $j->getMessage());
        }
    }
    
}


