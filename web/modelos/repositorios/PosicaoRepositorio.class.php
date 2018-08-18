<?php

   /**
   * Lista de times
   *
   * @author Camilla Nicolau
   * 
   */
    class PosicaoRepositorio extends Posicao{
    
        public function __construct(){
          //Nada a fazer
        }
        public static function buscarPosicao(){
            try{
                $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                $QueryBuilder
                    ->select('*')
                    ->from('posicao_peladeiro')
                ;
                return $QueryBuilder->execute()->fetchAll();
            }catch(Erro $E){
                echo ('Erro');
            }
        }
    }