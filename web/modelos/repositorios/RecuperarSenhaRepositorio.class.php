<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecuperarSenhaRepositorio
 *
 * @author camil
 */
class RecuperarSenhaRepositorio  extends RecuperarSenha{
    
    public static function buscarId($id){
        $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('recupera_senha')
                ->where('id_recupera_senha = ?')
                ->setParameter(0, $id, \PDO::PARAM_INT)
            ;
            $ObjDados = $QueryBuilder->execute()->fetch();
            if (!$ObjDados)
                throw new Excecao("Registro de id ". $id . " não encontrado no banco de dados.");
    }
}
