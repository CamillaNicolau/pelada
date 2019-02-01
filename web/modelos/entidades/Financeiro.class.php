<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

class Financeiro {
    private $idLancamento;
    private $valorMensalista;
    private $valorDiarista;
    private $valorPelada;
    private $peladeiro;
    private $pelada;
    private $dataCriacao;
  
    public function __construct($idLancamento = null){
    
        switch (true)
        {
          case filter_var($idLancamento, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
          try
          { 
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
     * Define o time
     *
     * @param Pelada $Pelada
     * @return void
     */
    public function setPelada(Pelada $Pelada)
    {
        $this->pelada = $Pelada->idPelada;
    }

    /**
     * Requisita o Pelada
     *
     * @return Pelada
     */
    public function getPelada()
    {
        return new Pelada($this->pelada);
    }
    
    /**
     * Define o Usuario
     *
     * @param Usuario Usuario
     * @return void
     */
    public function setUsuario(Usuario $Usuario)
    {
        $this->peladeiro = $Usuario->idUsuario;
    }

    /**
     * Requisita o Peladeiro
     *
     * @return Peladeiro
     */
    public function getUsuario()
    {
        return new Usuario($this->peladeiro);
    }
}

