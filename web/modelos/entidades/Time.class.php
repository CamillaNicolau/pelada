<?php

   /**
   * Lista de times
   *
   * @author Camilla Nicolau
   * 
   */
  class Time{
    
    private $idTime;
    private $nome;
    
    public function __construct($idTime = null){
        switch (true)
        {
            case filter_var($idTime, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
            try
            {
          
                $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                $QueryBuilder
                    ->select('*')
                    ->from('time_futebol')
                    ->where('id_time_futebol = ?')
                    ->setParameter(0, $idTime, \PDO::PARAM_INT)
                ;
                $ObjDados = $QueryBuilder->execute()->fetch();
                if (!$ObjDados) {
                    echo("Registro de id ". $idTime . " não encontrado no banco de dados.");
                }
                $this->idTime = $ObjDados->id_time_futebol;
                $this->nome = $ObjDados->nome;
            } catch(Exception $ex){
                echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idTime.' do tipo '.gettype($idTime));
            }
        }
    }
    
    public function __get($atributo){
        switch($atributo){
            case 'idTime':
            case 'nome':
                return $this->$atributo;
            break;
            default:
                echo('Atributo' .$atributo. 'desconhecido ou invalido na class '.__CLASS__);
            break;
        }
    }
}