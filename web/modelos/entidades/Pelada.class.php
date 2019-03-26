<?php

class Pelada{
  
    private $idPelada;
    private $nome;
    private $descricao;
    private $duracaoPartida;
    private $qtJogadores;
    private $sorteio;
    private $dataPartida;
    private $dataCriacao;
    private $localizacao;
    private $fkPeladeiroAdm;
    private $status;

    /**
     * Agrupa os itens antes de salvar no banco.
     *
     * @var array
     */
    private $peladeiros = array();
    private $horario;
  
    public function __construct($idPelada = null){
    
        switch (true)
        {
          case filter_var($idPelada, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
          try
          { 
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
              echo ('Erro ao instanciar classe Pelada id $idPelada. '. $ex->getMessage());
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
                echo ("A data de criação é um atributo privado da classe Usuario.");
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
    public function setLocalizacao(Localizacao $Localizacao)
    {
        $this->localizacao = $Localizacao->id_localizacao;
    }

    /**
     * Requisita o estado
     *
     * @return estado
     */
    public function getLocalizacao()
    {
        return new Localizacao($this->localizacao);
    }
    
     /**
     * Define o Usuario
     *
     * @param Usuario Usuario
     * @return void
     */
    public function setUsuario(Usuario $Usuario)
    {
        $this->fkPeladeiroAdm = $Usuario->idUsuario;
    }

    /**
     * Requisita o Peladeiro
     *
     * @return Peladeiro
     */
    public function getUsuario()
    {
        return new Usuario($this->fkPeladeiroAdm);
    }
    
     /**
     * Prepara os peladeiros antes de cadastrar.
     *
     * @param Usuario $Peladeiro
     */
    public function addPeladeiros(Usuario $Peladeiro)
    { 

        if ($Peladeiro->idUsuario) {
            $this->peladeiros[$Peladeiro->idUsuario] = $Peladeiro->nome; 
        }
    }
    
    
}
