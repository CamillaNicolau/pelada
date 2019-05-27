<?php

/**
 * Responsável pelos registros dos usuário no banco de dados.
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019
 */
class UsuarioRepositorio extends Usuario {
  
    /**
     * Realiza a listagem com os usuários registrados no banco de acordo com os parametros informados.
     *
     * @param array $condicoes Condições para a pesquisa ou um array vazio.
     * @param bool $order Parametro e o tipo de ordenação desejado. Exemplos: "id DESC", "nome ASC".
     * @param int $inicio Parametro para determinar o registro inicial da listagem.
     * @param int $limite Quantidade de registros para listagem.
     * @return array Retorna um array com os usuários de acordo com os parametros informados.
     * @fixme Método pode ser otimizado.
     */
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
          echo ("Erro ao buscar usuário ". $E->getMessage());
        }
    }
    
    /**
     * Adiciona um novo usuário criando seu registro no banco de dados.
     *
     * @return int retorna id do usuario caso operação seja realizado com sucesso.
     */
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
                ->setValue('data_nascimento', ':data_nascimento')
                ->setParameter(':nome', $Usuario->nome)
                ->setParameter(':email', $Usuario->email)
                ->setParameter(':apelido', $Usuario->apelido)
                ->setParameter(':senha', $Usuario->senha)
                ->setParameter(':sexo', $Usuario->sexo)
                ->setParameter(':url_imagem', $Usuario->urlImagem)
                ->setParameter(':ativo', $Usuario->ativo)
                ->setParameter(':data_nascimento', $Usuario->data_nascimento)
                ->execute()
            ;
            $Usuario->idUsuario = $QueryBuilder->getConnection()->lastInsertId();
            return $Usuario->idUsuario;
        } catch (Exception $j) {
            echo("Erro ao adicionar Usuario" . $j->getMessage());
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
            echo("Um erro ocorreu ao cadastrar a senha do peladeiro no banco de dados - " . $j->getMessage());
        }
    }
   
    /**
     * Salva as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @access public
     * @return string
     */
    public function adicionarParceiro($idUsuario, $idParceiro)
    {
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->insert('parceiro')
                ->setValue('fk_peladeiro', ':fk_peladeiro')
                ->setValue('fk_parceiro', ':fk_parceiro')
                ->setParameter(':fk_peladeiro', $idUsuario)
                ->setParameter(':fk_parceiro', $idParceiro)
                ->execute();
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao adicionar peladeiro ao parceiro no banco de dados - " . $j->getMessage());
        }
    }

    /**
     * Deleta o registro no banco de dados .
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function deletarUsuario($idUsuario) {
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->delete('usuario')
                ->where('id_usuario = :id_usuario')
                ->setParameter(':id_usuario', $idUsuario)
                ->execute()
            ; 
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao remover usuário no banco de dados - " . $j->getMessage());
        }
        return true;
    } 
}
