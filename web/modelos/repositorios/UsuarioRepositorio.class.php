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
  
  
  
    public static function buscarUsuario(array $condicoes = [], $order = false, $inicio = null, $limite = null){
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        try{
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
              ->select('*')
              ->from('usuario')
             
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
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
                ->setValue('nome', ':nome')
                ->setValue('email', ':email')
                ->setValue('apelido', ':apelido')
                ->setValue('senha', ':senha')
                ->setValue('sexo', ':sexo')
                ->setValue('url_imagem',':url_imagem')
                ->setValue('ativo',':ativo')
                ->setValue('data_criacao',':data_criacao')
                ->setParameter(':nome', $Usuario->nome)
                ->setParameter(':email', $Usuario->email)
                ->setParameter(':apelido', $Usuario->apelido)
                ->setParameter(':senha', $Usuario->senha)
                ->setParameter(':sexo', $Usuario->sexo)
                ->setParameter(':url_imagem', $Usuario->urlImagem)
                ->setParameter(':ativo', $Usuario->ativo)
                ->setParameter(':data_criacao',$Usuario->dataCriacao)
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
                ->setParameter(':email', $Usuario->email)
                ->setParameter(':senha', $Usuario->senha)
                ->setParameter(':nome', $Usuario->nome)
                ->setParameter(':apelido', $Usuario->apelido)
                ->setParameter(':sexo', $Usuario->sexo)
                ->setParameter(':url_imagem', $Usuario->urlImagem)
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
    
    /**
     * Salva as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @access public
     * @return string
     */
    public function adicionarSenha($idUsuario, $senha)
    {
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('usuario')
                ->set('senha', ':senha')
                ->setParameter(':senha', $senha)
                ->where('id_usuario = :id_usuario')
                ->setParameter(':id_usuario', $idUsuario)
                ->execute();
            
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao salvar a confirmação da pelada no banco de dados - " . $j->getMessage());
        }
    }
   
    
}
