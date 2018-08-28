<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Localizacao
 *
 * @author camil
 */
class Localizacao {
    //put your code here
    
    private $idLocalizacao;
    private $nomeQuadra;
    private $rua;
    private $bairro;
    private $numero;
    private $cidade;
    
    public function __construct($idLocalizacao = null) {
        
            if($idLocalizacao != null){
                try{
 
                    $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                    $QueryBuilder
                        ->select('*')
                        ->from('localizacao_pelada')
                        ->where('id_localizacao_pelada = ?')
                        ->setParameter(0, $idLocalizacao, \PDO::PARAM_INT)
                    ;
                    $ObjDados = $QueryBuilder->execute()->fetch();
                    if (!$ObjDados)
                        throw new Excecao("Registro de id ". $idLocalizacao . " não encontrado no banco de dados.");
                    $this->idLocalizacao = $ObjDados->id_localizacao_pelada;
                    $this->nomeQuadra = $ObjDados->nome_quadra;
                    $this->rua = $ObjDados->rua;
                    $this->bairro = $ObjDados->bairro;
                    $this->numero = $ObjDados->numero;
                    $this->cidade = $ObjDados->fk_cidade;
                } catch (Exception $ex) {
                    echo ('Erro ao instanciar classe Localização id idLocalizacao. '. $ex->getMessage());
                }
            } else if(is_null($idLocalizacao)){

                         //Nao faz nada
            }else{
    
              echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idLocalizacao.' do tipo '.gettype($idLocalizacao));
       
        }
        
    }
    public function __get($atributo) {
        switch ($atributo) {
            case 'idLocalizacao':
            case 'nomeQuadra':
            case 'rua':
            case 'bairro':
            case 'numero':
            case 'cidade':
                return $this->$atributo;
            break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
    
    public function __set($atributo, $value) {
        
        switch ($atributo) {
            case 'idLocalizacao':
            case 'nomeQuadra';
            case 'rua':
            case 'bairro':
            case 'numero':
            case 'cidade':
                $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
            break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }  
    }
    /**
     * Define a Cidade
     *
     * @param Cidade $Cidade
     * @return void
     */
    public function setCidade(Cidade $Cidade)
    {
        $this->cidade = $Cidade->idCidade;
    }

    /**
     * Requisita a Cidade
     *
     * @return Cidade
     */
    public function getCidade()
    {
        return new Cidade($this->cidade);
    }
}
