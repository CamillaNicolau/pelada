<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author camilla
 */
class UsuarioRepositorio extends Usuario {
  
  
  
  public static function buscarUsuario($email, $ativo = true){
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
              ->select('*')
              ->from('usuario')
              ->where('email = :email')
              ->setParameter(':email',$email)
            ;
            if ($ativo) {
                $QueryBuilder
                    ->andWhere('ativo = :ativo')
                    ->setParameter(':ativo', $ativo, \PDO::PARAM_INT)
                ;
            }
            return $QueryBuilder->execute()->fetchAll();
        }catch(Erro $E){
          echo ('Erro'.$E);
        }
    }
    
    public function adicionaUsuario(Usuario $Usuario) {

        if($Usuario->idUsuario){
           echo("Método adicionaUsuario() utilizado em objeto que já é instância de usuário válido.");
        } 
        try {
          $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->insert('usuario')
               ->setValue('email', ':email')
               ->setValue('senha', ':senha')
               ->setValue('nome', ':nome')
               ->setValue('apelido', ':apelido')
               ->setValue('sexo', ':sexo')
               ->setValue('urlImagem',':urlImagem')
               ->setValue('dataCriacao',':dataCriacao')
               ->setParameter(':email', $Usuario->email)
               ->setParameter(':senha', $Usuario->senha)
               ->setParameter(':nome', $Usuario->nome)
               ->setParameter(':apelido', $Usuario->apelido)
               ->setParameter(':sexo', $Usuario->sexo)
               ->setParameter(':urlmagem', $Usuario->urlImagem)
               ->setParameter(':dataCriacao',$Usuario->dataCriacao)
               ->execute()
            ;  
          $Usuario->idUsuario = $QueryBuilder->getConnection()->lastInsertId();
          return $Usuario->idUsuario;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Usuario");
        }   
    }
  
    /**
     * Salva as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @access public
     * @return string
     */
    public function atualizarUsuario(Usuario $Usuario,$path_imagem = false)
    {
        if ($path_imagem) {
            UsuarioModelo::salvaFoto($path_imagem);
        }
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('usuario')
                ->set('email', ':email')
                ->set('senha', ':senha')
                ->set('nome', ':nome')
                ->set('apelido', ':apelido')
                ->set('sexo', ':sexo')
                ->set('url_imagem',':url_imagem')
//                ->set('dataAlteracao',':dataAlteracao')
                ->setParameter(':email', $Usuario->email)
                ->setParameter(':senha', $Usuario->senha)
                ->setParameter(':nome', $Usuario->nome)
                ->setParameter(':apelido', $Usuario->apelido)
                ->setParameter(':sexo', $Usuario->sexo)
                ->setParameter(':url_imagem', $Usuario->urlImagem)
//                ->setParameter(':dataAlteracao',date("Y-m-d H:i:s"))
                ->where('id_usuario = :id_usuario')
                ->setParameter(':id_usuario', $Usuario->idUsuario)
                ->execute()
            ;
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao salvar um conteudo do usuario no banco de dados - " . $j->getMessage());
        }
    }
    /**
     * Desativa o usuário no sistema.
     *
     * @return boolen
     */
    public static function desativar($id)
    {
        $Usuario = new Usuario($id);
        $Usuario->ativo = false;
        try
        {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('usuario')
                ->set('ativo', ':ativo')
                ->setParameter(':ativo', 0, \PDO::PARAM_INT)
                ->where('idUsuario = :idUsuario')
                ->setParameter(':idUsuario', $id, \PDO::PARAM_INT)
                ->execute()
            ;
            return true;
        } catch (\Exception $j) {
            throw new Excecao('Erro ao desativar Usuario '. $j->getMessage());
        }
    }
   
    
}
