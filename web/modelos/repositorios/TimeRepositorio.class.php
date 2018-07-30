<?php

   /**
   * Lista de times
   *
   * @author Camilla Nicolau
   * 
   */
  class TimeRepositorio extends Time{
    
    public function __construct(){
      //Nada a fazer
    }
    public static function buscarTime(){
      try{
          $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
          $QueryBuilder
            ->select('*')
            ->from('time')
          ;
        return $QueryBuilder->execute()->fetchAll();
      }catch(Erro $E){
        echo ('Erro');
      }
    }
  }