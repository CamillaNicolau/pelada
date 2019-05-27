<?php

/**
 * Objeto que representa a pelada .
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class Pelada{

    /**
     * Chave identificadora da pelada no banco de dados.
     *
     * @var int
     */
    private $idPelada;

    /**
     * Nome da pelada.
     *
     * @var string
     */
    private $nome;

    /**
     * Descrição da pelada.
     *
     * @var string
     */
    private $descricao;

    /**
     * Tempo de duração da pelada.
     *
     * @var time
     */
    private $duracaoPartida;

    /**
     * Quantidade de jogadores cadastrados para a pelada.
     *
     * @var int
     */
    private $qtJogadores;

    /**
     * Tipo soretio ao iniciar a partida se será por ordem de chegada na pelada.
     *
     * @var string
     */
    private $sorteio;

    /**
     * Data para a pelada.
     *
     * @var int
     */
    private $dataPartida;

    /**
     * Horário definido para a pelada.
     *
     * @var int
    */
    private $horario;

    /**
     * Data da criação do registro no banco de dados.
     *
     * @var int
     */
    private $dataCriacao;

    /**
     * Objeto da localizacação ao qual pertence essa pelada.
     *
     * @var localizacao
     */
    private $localizacao;

    /**
     * Objeto da usuario ao qual criou essa pelada.
     *
     * @var fkPeladeiroAdm
     */
    private $fkPeladeiroAdm;

    /**
     * Status da pelada.
     * Ex.: Encerrada, em execução ...
     *
     * @var string
     */
    private $status;

    /**
     * Agrupa os itens antes de salvar no banco.
     *
     * @var array
     */
    private $peladeiros = array();

    /**
     * Instancia uma nova pelada baseado em sua chave identificadora do banco de dados
     * ou cria uma nova instância.
     *
     * @param int $idPelada Chave identificadora de uma pelada no banco de dados.
     * @return void
     */
    public function __construct($idPelada = null){
        switch (true){
            case filter_var($idPelada, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
                try {
                    $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                    $QueryBuilder
                       ->select('*')
                       ->from('pelada')
                       ->where('id_pelada = ?')
                       ->setParameter(0, $idPelada, \PDO::PARAM_INT)
                    ;
                    $ObjDados = $QueryBuilder->execute()->fetch();
                    if (!$ObjDados) {
                       echo("Registro de id ". $idPelada . " não encontrado no banco de dados.");
                    }
                      
                    $this->idPelada = $ObjDados->id_pelada;
                    $this->nome = $ObjDados->nome_pelada;
                    $this->descricao = $ObjDados->descricao;
                    $this->duracaoPartida = $ObjDados->duracao_pelada;
                    $this->qtJogadores = $ObjDados->qt_jogadores;
                    $this->sorteio = $ObjDados->sorteio;
                    $this->dataPartida = $ObjDados->data_pelada;
                    $this->localizacao = $ObjDados->fk_localizacao;
                    $this->fkPeladeiroAdm = $ObjDados->fk_criador;
                    $this->dataCriacao = $ObjDados->data_criacao;
                    $this->horario = $ObjDados->horario;
                    $this->status = $ObjDados->status;
                } catch(Exception $ex){
                  echo('Erro ao instanciar classe Pelada id $idPelada. '. $ex->getMessage());
                }
            break;
            case is_null($idPelada):
                $this->dataCriacao = date("Y-m-d H:i:s");
            break;
            default:
                echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idPelada.' do tipo '.gettype($idPelada));
            break;
        }
    }

    /**
     * Informa o dado do atributo solicitado ou dispara exceção caso atributo não exista.
     *
     * @param string $atributo Nome do atributo que deseja obter seu respectivo dado.
     * @return mixed Retorna dado do atributo informado.
     */
    public function __get($atributo) {   
        switch ($atributo) {
            case "idPelada":
            case "nome":
            case "descricao":
            case "duracaoPartida":
            case "qtJogadores":
            case "sorteio":
            case "peladeiros":
            case "localizacao":
            case "dataPartida":
            case "dataCriacao":
            case "fkPeladeiroAdm":
            case "horario":
            case "status":
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
            case "idPelada":
            case "nome":
            case "descricao":
            case "localizacao":
            case "duracaoPartida":
            case "qtJogadores":
            case "sorteio":
            case "peladeiros":
            case "dataPartida":
            case "fkPeladeiroAdm":
            case "horario":
            case "status":
                $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
            break;
            case "dataCriacao":
                echo ("A data de criação é um atributo privado da classe Pelada.");
            break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }

    /**
     * Define o estado
     *
     * @param Estado $Estado
     * @return void
     */
    public function setLocalizacao(Localizacao $Localizacao){
        $this->localizacao = $Localizacao->id_localizacao;
    }

    /**
     * Requisita o estado
     *
     * @return estado
     */
    public function getLocalizacao(){
        return new Localizacao($this->localizacao);
    }

    /**
     * Define o Usuario
     *
     * @param Usuario Usuario
     * @return void
     */
    public function setUsuario(Usuario $Usuario){
        $this->fkPeladeiroAdm = $Usuario->idUsuario;
    }

    /**
     * Requisita o Peladeiro
     *
     * @return Peladeiro
     */
    public function getUsuario(){
        return new Usuario($this->fkPeladeiroAdm);
    }

    /**
     * Prepara os peladeiros antes de cadastrar.
     *
     * @param Usuario $Peladeiro
     */
    public function addPeladeiros(Usuario $Peladeiro){ 
        if ($Peladeiro->idUsuario) {
            $this->peladeiros[$Peladeiro->idUsuario] = $Peladeiro->nome; 
        }
    }   
}
