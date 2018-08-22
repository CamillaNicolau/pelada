<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CidadeRepositorio
 *
 * @author Camilla Nicolau
 */
class CidadeRepositorio extends Cidade {
    
    public function __construct() {
       //Nada a fazer
    }
    
    public static function buscarCidade($estado){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('cidade')
                ->where('fk_estado = :fk_estado')
                ->setParameter(':fk_estado',$estado)
            ;
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $ex){
            echo ("Erro");
        }
    }
}
