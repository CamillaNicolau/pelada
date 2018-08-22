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
    
    public static function buscarLocalizacao($cidade){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('localizacao_pelada')
                ->where('fk_cidade = :fk_cidade')
                ->setParameter(':fk_cidade',$cidade)
            ;
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $ex){
            echo ("Erro");
        }
    }
    public function adicionaLocalizacao(Localizacao $Localizacao) {
        var_dump($Localizacao->idLocalizacao);
        if($Localizacao->idLocalizacao){
           echo("Método adicionaLocalizacao() utilizado em objeto que já é instância de usuário válido.");
        } 
        try {
          $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->insert('localizacao_pelada')
               ->setValue('rua', ':rua')
               ->setValue('bairro', ':bairro')
               ->setValue('numero', ':numero')
               ->setValue('fk_cidade', ':fk_cidade')
              
               ->setParameter(':rua', $Localizacao->rua)
               ->setParameter(':bairro', $Localizacao->bairro)
               ->setParameter(':numero', $Localizacao->numero)
               ->setParameter(':fk_cidade', $Localizacao->cidade)
               
               ->execute()
            ;  
          $Localizacao->idLocalizacao = $QueryBuilder->getConnection()->lastInsertId();
          return $Localizacao->idLocalizacao;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Localização");
        }   
    }
    //put your code here
}
