<?php

/**
 * Objeto que representa todos os times de futebol cadastrados.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Time{
    
    /**
     * Chave identificadora do time no banco de dados.
     *
     * @var int
     */
    private $idTime;

    /**
     * nome do time.
     *
     * @var string
     */
    private $nome;
    
    /**
     * Instancia um time baseado na sua chave identificadora do banco de dados ou cria uma nova instância.
     *
     * @param int $idTime Chave identificadora de um time no banco de dados.
     * @return void
     */
    public function __construct($idTime = null){
        switch (true){
            case filter_var($idTime, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
                try{
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
            break;
            case is_null($idTime):
              //Nada a fazer
            break;
        }
    }

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Valor do atributo no seu tipo original.
     */    
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