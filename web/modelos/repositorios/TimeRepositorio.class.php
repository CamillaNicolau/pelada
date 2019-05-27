<?php

/**
 * Listagem com os times registradas no banco
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2019
 */
class TimeRepositorio extends Time{
    
    /**
     * Realiza a listagem com os times registradas no banco de acordo com os parametros informados.
     *
     * @return array Retorna um array com as posições.
     */
    public static function buscarTime(){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('time_futebol')
            ;
            return $QueryBuilder->execute()->fetchAll();
        }catch(Erro $E){
            echo ("Erro ao buscar time". $j->getMessage());
        }
    }
}