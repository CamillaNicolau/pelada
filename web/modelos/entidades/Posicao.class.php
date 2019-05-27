<?php

/**
 * Objeto que representa a posição do peladeiro no sistema.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Posicao {
  
    /**
     * Chave identificadora do peladeiro no banco de dados.
     *
     * @var int
     */
    private $idPosicao;

    /**
     * Nome da cidade.
     *
     * @var string
    */
    private $nome;
  
    public function __construct($idPosicao = null){ 
        switch (true) {
            case filter_var($idPosicao, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
                try{
                    $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                    $QueryBuilder
                      ->select('*')
                      ->from('posicao_peladeiro')
                      ->where('id_posicao_peladeiro = ?')
                      ->setParameter(0, $idPosicao, \PDO::PARAM_INT)
                    ;
                    $ObjDados = $QueryBuilder->execute()->fetch();
                    if (!$ObjDados) {
                      echo("Registro de id ". $idPosicao . " não encontrado no banco de dados.");
                    }
                    $this->idPosicao = $ObjDados->id_posicao_peladeiro;
                    $this->nome = $ObjDados->nome;
                } catch(Exception $ex){
                     echo ('Erro ao instanciar classe Posicao id $idPosicao. '. $ex->getMessage());
                }
            break;
            case is_null($idPosicao):
              //Nada a fazer
            break;
            default:
                echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idPosicao.' do tipo '.gettype($idPosicao));
            break;
        }
    }

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Retorna dado do atributo informado.
     */
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