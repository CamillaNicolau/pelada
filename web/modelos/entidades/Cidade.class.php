<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author camil
 */
class Cidade {
    //put your code here
    private $idCidade;
    private $nome_cidade;
    private $estado;
    
    public function __construct($idCidade = null) {
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('cidade')
                ->where('id_cidade = ?')
                ->setParameter(0, $idCidade, \PDO::PARAM_INT)
            ;
            $ObjDados = $QueryBuilder->execute()->fetch();
            if (!$ObjDados) {
                echo("Registro de id ". $idCidade . " não encontrado no banco de dados.");
            }
            $this->idCidade = $ObjDados->id_cidade;
            $this->nome_cidade = $ObjDados->nome_cidade;
            $this->estado = $ObjDados->fk_estado;
        } catch(Exception $ex){
            echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idCidade.' do tipo '.gettype($idCidade));
        }
    }
    public function __get($atributo) {
        switch($atributo){
            case 'idCidade':
            case 'nome_cidade':
            case 'estado':
                return $this->$atributo;
            break;
            default:
                echo('Atributo' .$atributo. 'desconhecido ou invalido na class '.__CLASS__);
            break;
        }
    }
    public function __set($atributo,$value) {
        switch($atributo){
            case 'idCidade':
            case 'nome_cidade':
            case 'estado':
                $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
            break;
            default:
                echo('Atributo' .$atributo. 'desconhecido ou invalido na class '.__CLASS__);
            break;
        }
    }
    /**
     * Define a estado
     *
     * @param Estado $Estado
     * @return void
     */
    public function setEstado(Estado $Estado)
    {
        $this->estado = $Estado->idEstado;
    }

    /**
     * Requisita a estado
     *
     * @return estado
     */
    public function getEstado()
    {
        return new Estado($this->estado);
    }
}
