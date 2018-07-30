<?php

class Posicao {
  
  private $idPosicao;
  private $nome;
  
    public function __construct($idPosicao = null){
      
      switch (true) {
          case filter_var($idPosicao, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
          try
          {
              $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
              $QueryBuilder
                  ->select('*')
                  ->from('posicao')
                  ->where('idPosicao = :idPosicao')
                  ->setParameter(':idPosicao', $idPosicao, \PDO::PARAM_INT)
              ;
              $ObjDados = $QueryBuilder->execute()->fetch();
              if (!$ObjDados) {
                  echo("Registro de id ". $idPosicao . " não encontrado no banco de dados.");
              }
              $this->idPosicao = $ObjDados->idPosicao;
              $this->nome = $ObjDados->nome;
          } catch(Exception $ex){

          }
          break;
          default:
              echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idPosicao.' do tipo '.gettype($idPosicao));
          break;
      }
    }
    public function __get($atributo){
      switch($atributo){
        case 'idPosicao':
        case 'nome':
          return $this->$atributo;
         break;
         default:
          echo('Atributo' . $atributo . 'desconhecido ou invalido na class '.__CLASS__);
         break;
      }
    }
}