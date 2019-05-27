<?php

/**
 * Listagem com as posições registradas no banco
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2019
 */
class PosicaoRepositorio extends Posicao{

    /**
     * Realiza a listagem com as posições registradas no banco de acordo com os parametros informados.
     *
     * @return array Retorna um array com as posições.
     */
    public static function buscarPosicao(){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('posicao_peladeiro')
            ;
            return $QueryBuilder->execute()->fetchAll();
        }catch(Erro $j){
            echo ('Erro ao buscar posição ' . $j->getMessage());
        }
    }
}