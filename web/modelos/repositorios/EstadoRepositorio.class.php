<?php

/**
 * Lista de times
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class EstadoRepositorio extends Estado{
    
    public function __construct() {
      //Nada há fazer
    }
    public static function buscarEstado(){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('estado')
            ;
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $ex) {
            echo ('Erro');
        }
    }
}
