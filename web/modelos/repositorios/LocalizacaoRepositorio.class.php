<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LocalizacaoRepositorio
 *
 * @author camil
 */
class LocalizacaoRepositorio extends Localizacao {
    
  public function __construct() {
       //Nada a fazer
    }
    
    public static function buscarLocalizacao(array $condicoes = [], $order = false, $inicio = null, $limite = null){
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('localizacao_pelada')
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
            echo ("Erro ao buscar localizacao". $j->getMessage());
        }
    }
       
    public function adicionaLocalizacao(Localizacao $Localizacao) {
        
      
        try {
          $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->insert('localizacao_pelada')
               ->setValue('nome_quadra', ':nome_quadra')
               ->setValue('rua', ':rua')
               ->setValue('bairro', ':bairro')
               ->setValue('numero', ':numero')
               ->setValue('fk_cidade', ':fk_cidade')
               ->setParameter(':nome_quadra', $Localizacao->nomeQuadra)
               ->setParameter(':rua', $Localizacao->rua)
               ->setParameter(':bairro', $Localizacao->bairro)
               ->setParameter(':numero', $Localizacao->numero)
               ->setParameter(':fk_cidade', $Localizacao->cidade) 
               ->execute()
            ;  
         
          $Localizacao->idLocalizacao = $QueryBuilder->getConnection()->lastInsertId();
              
         return $Localizacao->idLocalizacao;
        } catch (Exception $ex) {
            echo('Erro ao adicionar na classe '.__CLASS__.': '.$ex->getMessage());
        }   
    }

   
    //put your code here
}
