<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

class Peladeiro {
    private $idPeladeiro;
    private $nome;
    private $email;
    private $telefone;
    private $data_nascimento;
    private $url_imagem;
    private $participacao;
    protected $usuario;
    protected $marcacoes;
    /**
     * Senha criptografada do usuário. Ao ser alterada é criptografada internamente automaticamente.
     *
     * @var string
     */
    protected $senha;
    /**
     * Qual posição o usuário joga.
     *
     * @var string
     */
    protected $posicao;
    
    /**
     * Qual o time que o usuario.
     *
     * @var string
     */
    protected $timeFutebol;
    
    public function __construct($idPeladeiro = null){
    
        switch (true)
        {
          case filter_var($idPeladeiro, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
          try
          { 
                $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                $QueryBuilder
                    ->select('*')
                    ->from('usuario')
                    ->where('id_usuario = ?')
                    ->setParameter(0, $idPeladeiro, \PDO::PARAM_INT)
                ;
                $ObjDados = $QueryBuilder->execute()->fetch();
                if (!$ObjDados) {
                    echo("Registro de id ". $idPeladeiro . " não encontrado no banco de dados.");
                }
                
                $this->idPeladeiro = $ObjDados->id_usuario;
                $this->nome = $ObjDados->nome;
                $this->email = $ObjDados->email;
                $this->telefone = $ObjDados->telefone;
                $this->data_nascimento = $ObjDados->data_nascimento;
                $this->url_imagem = $ObjDados->url_imagem;
                $this->participacao = $ObjDados->participacao;
                $this->usuario = $ObjDados->fk_criador;
                $this->marcacoes = $ObjDados->fk_marcacoes;
                $this->timeFutebol = $ObjDados->fk_time_futebol;
                $this->posicao = $ObjDados->fk_posicao;


            } catch(Exception $ex){
              echo ('Erro ao instanciar classe Peladeiro id $idPeladeiro. '. $ex->getMessage());
            }
            break;
            case is_null($idPeladeiro):
              //Nada a fazer
            break;
            default:
              echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idPeladeiro.' do tipo '.gettype($idPelada));
            break;
        }
    }
    public function __get($atributo) {
        
        switch ($atributo) {
            case "idPeladeiro":
            case "nome":
            case "email":
            case "telefone":
            case "data_nascimento":
            case "url_imagem":
            case "participacao":
            case "usuario":
            case "senha":
            case "marcacoes":
            case "timeFutebol":
            case "posicao":
                return $this->$atributo;
            break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
    public function __set($atributo, $value) {
        
        switch ($atributo) {
            
            case "idPeladeiro":
            case "nome":
            case "email":
            case "telefone":
            case "data_nascimento":
            case "senha":
            case "url_imagem":
            case "participacao":
            case "usuario":
            case "marcacoes":
            case "timeFutebol":
            case "posicao":
                $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
                break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
    
      /**
     * Define o time
     *
     * @param Time $Time
     * @return void
     */
    public function setTime(Time $Time)
    {
        $this->timeFutebol = $Time->idTime;
    }

    /**
     * Requisita o time
     *
     * @return Time
     */
    public function getTime()
    {
        return new Time($this->timeFutebol);
    }
    /**
     * Define a posicao
     *
     * @param Posicao $Posicao
     * @return void
     */
    public function setPosicao(Posicao $Posicao)
    {
        $this->posicao = $Posicao->idPosicao;
    }

    /**
     * Requisita a posicao
     *
     * @return Time
     */
    public function getPosicao()
    {
        return new Posicao($this->posicao);
    }
    
     /**
     * Define o Usuario
     *
     * @param Usuario Usuario
     * @return void
     */
    public function setUsuario(Usuario $Usuario)
    {
        $this->usuario = $Usuario->idUsuario;
    }

    /**
     * Requisita o Peladeiro
     *
     * @return Peladeiro
     */
    public function getUsuario()
    {
        return new Usuario($this->usuario);
    }
    
     /**
     * Define as marcações
     *
     * @param Marcacao Marcacao
     * @return void
     */
    public function setMarcacao(Marcacao $Marcacao)
    {
        $this->marcacoes = $Marcacao->idMarcacao;
    }

    /**
     * Requisita a marcação do peladeiro
     *
     * @return Marcacao
     */
    public function getMarcacao()
    {
        return new Marcacao($this->marcacoes);
    }
    
}

