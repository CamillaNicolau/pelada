<?php

/**
 * Description of PeladeiroRepositorio
 *
 * @author Camilla Nicolau
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
                ->from('financeiro_peladeiro')
               
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
            ->setParameter(':fk_peladeiro', $lancamento['peladeiro'], \PDO::PARAM_INT)
            ->setParameter(':fk_financeiro', $lancamento['financeiro'], \PDO::PARAM_INT)
            ->setParameter(':valor_pago',$lancamento['valor_pago'])
            ->setParameter(':status_pagamento', $lancamento['status'])
            ->execute()
        ;
      } catch (\Exception $e26811) {
          echo('Erro ao adicionar na classe '.__CLASS__.': '.$e26811->getMessage());
      }
      return true;
    }

    public function atualizarPeladeiroPagamento($lancamento){
      try {
        $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
        $QueryBuilder
            ->update('financeiro_peladeiro')
            ->set('valor_pago', ':valor_pago')
            ->set('status_pagamento', ':status_pagamento')
            ->setParameter(':valor_pago',$lancamento['valor_pago'])
            ->setParameter(':status_pagamento', $lancamento['status'])
            ->where('id_financeiro_peladeiro = :id_financeiro_peladeiro')
            ->setParameter(':id_financeiro_peladeiro', $lancamento['fp'])
            ->execute()
            ;
      } catch (\Exception $e26811) {
          echo('Erro ao atualizar na classe '.__CLASS__.': '.$e26811->getMessage());
      }
      return true;
    }
}
