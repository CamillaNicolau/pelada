<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */

class Usuario {
    
    /**
     * Chave identificadora do usuário no banco de dados.
     *
     * @var int
     */
    private $idUsuario;
    
    /**
     * Endereço de e-mail do usuário no sistema.
     *
     * @var string
     */
    private $email;
    
    /**
     * Senha criptografada do usuário. Ao ser alterada é criptografada internamente automaticamente.
     *
     * @var string
     */
    protected $senha;
    
    /**
     * Nome do usuário.
     *
     * @var string
     */
    protected $nome;
    
    /**
     * Apelido do usuário.
     *
     * @var string
     */
    protected $apelido;
    
    /**
     * Sexo do usuário.
     *
     * @var string
     */
    protected $sexo;
   
    /**
     * Data em que foi criado o usuário.
     *
     * @var datatime
     */
    protected $dataCriacao;

    /**
     * estado do usuário no sistema, sendo ele ativo ou desativado.
     *
     * @var bool
     */
    protected $ativo;
   
    /**
    * Armazena url da imagem do usuário
    * @var string 
    */
    private $urlImagem;
    
    public function __construct($idUsuario = null) {

        switch (true)
        {
         case filter_var($idUsuario, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]):
                try
                {
                    $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                    $QueryBuilder
                        ->select('*')
                        ->from('usuario')
                        ->where('id_usuario = ?')
                        ->setParameter(0, $idUsuario, \PDO::PARAM_INT)
                        ;
                    $ObjDados = $QueryBuilder->execute()->fetch();
                    if (!$ObjDados){
                        throw new Excecao("Registro de id ". $idUsuario . " não encontrado no banco de dados.");
                    }

                    $this->idUsuario = $ObjDados->id_usuario;
                    $this->email = $ObjDados->email;
                    $this->senha = $ObjDados->senha;
                    $this->nome = $ObjDados->nome;
                    $this->apelido = $ObjDados->apelido;
                    $this->sexo = $ObjDados->sexo;
                    $this->dataCriacao = $ObjDados->data_criacao;
                    $this->ativo = $ObjDados->ativo;
                    $this->urlImagem = $ObjDados->url_imagem;
                } catch(Exception $ex){
                   echo ('Erro ao instanciar classe Usuario id $idUsuario. '. $ex->getMessage());
                }
            break;
            case (is_null($idUsuario)):
                $this->ativo = true;
                $this->dataCriacao = date("Y-m-d H:i:s");
            break;
            default:
                echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idUsuario.' do tipo '.gettype($idUsuario));
            break;
        }
    }
    
    public function __get($atributo) {
        
        switch ($atributo) {
            case "idUsuario":
            case "email":
            case "senha":
            case "nome":
            case "apelido":
            case "sexo":
            case "dataCriacao":
            case "ativo":
            case "urlImagem":
                return $this->$atributo;
            break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
    public function __set($atributo, $value) {
        
        switch ($atributo) {
            
            case "idUsuario":
            case "email":
            case "senha":
            case "nome":
            case "apelido":
            case "sexo":
            case "urlImagem":
                $this->$atributo = (($value || $value === 0 || $value === '0' )?$value:null);
                break;
            case "dataCriacao":
                echo ("A data de criação é um atributo privado da classe Usuario.");
                break;
            case "ativo":
                echo ("O atributo ativo é privado.");
                break;
            default:
                echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }

}
