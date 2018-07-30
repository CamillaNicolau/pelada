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
  private $fkUsuario;
  
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
                  ->where('idPelada = ?')
                  ->setParameter(0, $idPelada, \PDO::PARAM_INT)
              ;
              $ObjDados = $QueryBuilder->execute()->fetch();
              if (!$ObjDados) {
                  echo("Registro de id ". $idPelada . " não encontrado no banco de dados.");
              }
           
              $this->idPelada = $ObjDados->idPelada;
              $this->nome = $ObjDados->nome;
              $this->descricao = $ObjDados->descricao;
              $this->duracaoPartida = $ObjDados->duracaoPartida;
              $this->qtJogadores = $ObjDados->qtJogadores;
              $this->sorteio = $ObjDados->sorteio;
              $this->dataPartida = $ObjDados->dataPartida;
              $this->fkUsuario = $ObjDados->fk_usuario;
              $this->dataCriacao = $ObjDados->dataCriacao;

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
            case "dataPartida":
            case "dataCriacao":
            case "fkUsuario":
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
            case "duracaoPartida":
            case "qtJogadores":
            case "sorteio":
            case "dataPartida":
            case "fkUsuario":
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
  }
