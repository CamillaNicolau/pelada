<?php

/**
 * Objeto que representa as cidades do sistema.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Cidade {
    
    /**
     * Chave identificadora da cidade no banco de dados.
     *
     * @var int
     */
    private $idCidade;

    /**
     * Nome da cidade.
     *
     * @var string
     */
    private $nome_cidade;

    /**
     * Objeto do estado ao qual pertence essa cidade.
     *
     * @var estado
     */
    private $estado;
    
    /**
     * Instancia uma cidade de acordo com o código informado.
     *
     * @param int $idCidade Chave identificadora da cidade no banco de dados.
     * @return void
     */
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

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Retorna dado do atributo informado.
     */
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

    /**
     * Atribui o dado ao objeto de acordo com o atributo informado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que receberá o valor desejado.
     * @param mixed $value Dado que o atributo deve receber.
     * @return void
     */
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
    public function setEstado(Estado $Estado){
        $this->estado = $Estado->idEstado;
    }

    /**
     * Requisita o estado
     *
     * @return estado
     */
    public function getEstado(){
        return new Estado($this->estado);
    }
}
