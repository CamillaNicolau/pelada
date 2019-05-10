<?php

/**
 * Representação dos estados da federação brasileira para o sistema.
 * Possui apenas nome e sigla.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Estado {

    /**
     * Chave identificadora do estado no banco de dados.
     *
     * @var int
     */
    private $idEstado;

    /**
     * Nome do estado.
     *
     * @var string
     */
    private $nome;

    /**
     * Sigla de duas letras padrão do estado.
     *
     * @var string
     */
    private $sigla;
    
    /**
     * Instancia um estado baseado no seu código do banco de dados ou cria uma nova instância.
     * Caso um idEstado não seja informado ele irá criar um novo, e métodos como excluir() e salvar()
     * não estarão disponíveis.
     *
     * @param int $idEstado Chave identificadora de um estado no banco.
     */
    public function __construct($idEstado = null) {
        try {
            
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
            $this->nome = $ObjDados->nome_estado;
            $this->sigla = $ObjDados->sigla;
        } catch(Exception $ex){
            echo('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idEstado.' do tipo '.gettype($idEstado));
        }
    }

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Valor do atributo no seu tipo original.
     */
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
