<?php

/**
 * Description of Estado
 *
 * @author camilla
 */
class Estado {

    private $idEstado;
    private $nome;
    private $sigla;
    
    public function __construct($idEstado = null) {
        try
        {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('estado')
                ->where('id_estado = ?')
                ->setParameter(0, $idEstado, \PDO::PARAM_INT)
            ;
            $ObjDados = $QueryBuilder->execute()->fetch();
            if (!$ObjDados) {
                echo("Registro de id ". $idEstado . " não encontrado no banco de dados.");
            }
            $this->idEstado = $ObjDados->id_estado;
            $this->nome = $ObjDados->nome;
            $this->sigla = $ObjDados->sigla;
        } catch(Exception $ex){
            echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idEstado.' do tipo '.gettype($idEstado));
        }
    }
    public function __get($atributo) {
        switch($atributo){
            case 'idEstado':
            case 'nome':
            case 'sigla':
                return $this->$atributo;
            break;
            default:
                echo('Atributo' .$atributo. 'desconhecido ou invalido na class '.__CLASS__);
            break;
        }
    }
}
