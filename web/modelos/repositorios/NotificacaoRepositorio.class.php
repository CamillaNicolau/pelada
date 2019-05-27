<?php

/**
 * Gerenciar os dados a serem enviados e recebidos do banco
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019 
 */
class NotificacaoRepositorio {
    
    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     * 
     * @param array $condicoes
     * @param type $order
     * @param type $inicio
     * @param type $limite
     * @return array
     */
    public static function buscarNotificacao(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('pelada_candidato','pc')
                ->join('pc','pelada','p','pc.fk_pelada = p.id_pelada')
                ->join('p','usuario','u','pc.fk_candidato = u.id_usuario')
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
            if($order){
                $QueryBuilder->orderBy('data_solicitacao','desc');
            }
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao buscar notificação". $j->getMessage());
        }
    }

    /**
     * Conta a quantidade total de notificações
     *
     * @param array $condicoes
     * @return int
     */
    public static function contarNotificacao(array $condicoes = []) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('count(visualizada) as total')
                ->from('pelada_candidato','pc')
                ->join('pc','pelada','p','pc.fk_pelada = p.id_pelada')  
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao contar as notificações". $j->getMessage());
        }
    }

    /**
     * Atualiza os dados do objeto no banco de dados.
     *
     * @param array $condicoes
     * @param bool $visualizacao
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function visualizaNotificacao(array $condicoes = [], $visualizacao)
    {
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('pelada_candidato')
                ->set('visualizada', ':visualizada')
                ->setParameter(':visualizada', $visualizacao)
                ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            return $QueryBuilder->execute();
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao atualizar a visualização no banco de dados - " . $j->getMessage());
        }
    }
}