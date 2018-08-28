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
    
    public static function buscarCidade(
            $id_cidade = null,
            $nome = null,
            $estado = null,
            $order = false, $inicio = null, $limite = null
        ){
 
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('cidade')
            ;
            if ($estado) {
                $QueryBuilder
                    ->where('fk_estado = :fk_estado')
                    ->setParameter(':fk_estado', $estado);
            }
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $ex){
            echo ("Erro");
        }
    }
}
