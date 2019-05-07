
<?php

class NotificacaoRepositorio {
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
            echo ("Erro ao buscar notificação". $j->getMessage());
        }
    }

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