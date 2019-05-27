<?php

/**
 * Objeto que representa os dados financeiros cadastrados no sistema.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019 
 */

class Financeiro {

    /**
     * Chave identificadora da lançamento no banco de dados.
     *
     * @var int
    */
    private $idLancamento;

    /**
     * Valor da mensalidade da pelada.
     *
     * @var float
    */
    private $valorMensalista;

    /**
     * Valor da diária da pelada.
     *
     * @var float
    */
    private $valorDiarista;

    /**
     * Valor total da pelada.
     *
     * @var int
    */
    private $valorPelada;

    /**
     * Objeto da usuario ao qual registrou o lançamento.
     *
     * @var peladeiro
    */
    private $peladeiro;

    /**
     * Objeto da pelada ao qual vinculou o lançamento.
     *
     * @var pelada
    */
    private $pelada;

    /**
     * Data da criação do registro no banco de dados.
     *
     * @var int
     */
    private $dataCriacao;

    /**
     * Instancia do lançamento baseado em sua chave identificadora do banco de dados ou cria uma nova instância.
     *
     * @param int $idLancamento Chave identificadora de um usuário no banco de dados.
     * @return void
     */
    public function __construct($idLancamento = null){
        switch (true){
            case filter_var($idLancamento, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
                try{ 
                    $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                    $QueryBuilder
                        ->select('*')
                        ->from('financeiro')
                        ->where('id_lancamento = ?')
                        ->setParameter(0, $idLancamento, \PDO::PARAM_INT)
                    ;
                    $ObjDados = $QueryBuilder->execute()->fetch();
                    if (!$ObjDados) {
                        echo("Registro de id ". $idLancamento . " não encontrado no banco de dados.");
                    }
                  
                    $this->idLancamento = $ObjDados->id_lancamento;
                    $this->valorMensalista = $ObjDados->mensalidade;
                    $this->valorDiarista = $ObjDados->diaria;
                    $this->valorPelada = $ObjDados->total_pelada;
                    $this->peladeiro = $ObjDados->fk_peladeiro;
                    $this->pelada = $ObjDados->fk_pelada;
                    $this->dataCriacao = $ObjDados->data_criacao;
                } catch(Exception $ex){
                  echo ('Erro ao instanciar classe Financeiro id $idLancamento. '. $ex->getMessage());
                }
            break;
            case is_null($idLancamento):
                $this->dataCriacao = date("Y-m-d H:i:s");
            break;
            default:
                echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idLancamento.' do tipo '.gettype($idLancamento));
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
            case "idLancamento":
            case "valorMensalista":
            case "valorDiarista":
            case "valorPelada":
            case "peladeiro":
            case "pelada":
            case "dataCriacao":
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
          case "idLancamento":
          case "valorMensalista":
          case "valorDiarista":
          case "valorPelada":
          case "peladeiro":
          case "pelada":
            $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
            break;
          case "dataCriacao":
            echo ("A data de criação é um atributo privado da classe Financeiro.");
          break;
          default:
            echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
          break;
        }
    }
  
    /**
     * Define a pelada
     *
     * @param Pelada $Pelada
     * @return void
     */
    public function setPelada(Pelada $Pelada){
        $this->pelada = $Pelada->idPelada;
    }

    /**
     * Requisita a Pelada
     *
     * @return Pelada
     */
    public function getPelada(){
        return new Pelada($this->pelada);
    }
  
    /**
     * Define o Peladeiro
     *
     * @param Usuario Usuario
     * @return void
     */
    public function setUsuario(Usuario $Usuario){
        $this->peladeiro = $Usuario->idUsuario;
    }

    /**
     * Requisita o Peladeiro
     *
     * @return Peladeiro
     */
    public function getUsuario(){
        return new Usuario($this->peladeiro);
    }
}

