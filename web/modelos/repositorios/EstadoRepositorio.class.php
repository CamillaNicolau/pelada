<?php

/**
 * Listagem com os estados registradas no banco
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2019
 */
class EstadoRepositorio extends Estado{

    /**
     * Realiza a listagem com os estados registradas no banco de acordo com os parametros informados.
     *
     * @return array Retorna um array com as cidades.
     */
    public static function buscarEstado(){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('estado')
            ;
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $j) {
            echo ('Erro ao buscar o estado' . $j->getMessage());
        }
    }
}
