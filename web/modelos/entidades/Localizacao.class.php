<?php

/**
 * Objeto que representa todos os locais e endereços das peladas cadastradas.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Localizacao {
    
    /**
     * Chave identificadora do local no banco de dados.
     *
     * @var int
     */
    private $idLocalizacao;

    /**
     * nome do local.
     *
     * @var string
     */
    private $nomeQuadra;

    /**
     * Endereço do local.
     *
     * @var string
     */
    private $rua;

    /**
     * Bairro do Local.
     *
     * @var string
     */
    private $bairro;

    /**
     * número de identificação de onde o local está situado.
     *
     * @var int
     */
    private $numero;

    /**
     * Cidade onde o local está situado.
     *
     * @var Cidade
     */
    private $cidade;
    
    /**
     * Instancia um local baseado na sua chave identificadora do banco de dados ou cria uma nova instância.
     *
     * @param int $idLocalizacao Chave identificadora de um local no banco de dados.
     * @return void
     */
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
                if (!$ObjDados) {
                    throw new Excecao("Registro de id ". $idLocalizacao . " não encontrado no banco de dados.");
                }
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

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Valor do atributo no seu tipo original.
     */
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
    
    /**
     * Atribui o dado ao objeto de acordo com o atributo informado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que receberá o valor desejado.
     * @param mixed $value Dado que o atributo deve receber.
     * @return void
     */
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
    public function setCidade(Cidade $Cidade){
        $this->cidade = $Cidade->idCidade;
    }

    /**
     * Requisita a Cidade
     *
     * @return Cidade
     */
    public function getCidade(){
        return new Cidade($this->cidade);
    }
}
