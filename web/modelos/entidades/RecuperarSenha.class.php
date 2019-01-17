<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecuperarSenha
 *
 * @author Camilla Nicolau
 */
class RecuperarSenha {

    private $idRecuperaSenha;
    private $email;
    private $token;
    private $ativo;
    private $dataCriacao;
    
    public function __construct($id = null) {
        if($id){
            $RecuperaSenha = RecuperarSenhaRepositorio::buscarId($id);
            $this->email = $RecuperaSenha->email;
            $this->token = $RecuperaSenha->token;
            $this->ativo = $RecuperaSenha->ativo;
        } else if(is_null($id)){
            $this->ativo = TRUE;
            $this->dataCriacao = date("Y-m-d H:i:s");
        } else{
            echo ('Tentativa de injection na classe '.__CLASS__.', variável $id recebeu o valor '.$idPelada.' do tipo '.gettype($id));
        }
    }
    
    public function __get($atributo) {
        switch ($atributo){
            case "idRecuperarSenha":
            case "email":
            case "token":
            case "ativo":
            case "dataCriacao":
                return $this->$atributo;
            break;
            default :
               echo ("Atributo '" . $atributo . "' desconhecido, privado ou inválido da classe '" . __CLASS__ . "'.");
            break;
        }
    }
    
    public function __set($atributo, $valor) {
        switch ($atributo){
            case "idRecuperarSenha":
            case "token":
            case "email":
                $this->$atributo = (($valor || $valor === 0 || $valor === '0' )?$valor:null);
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
