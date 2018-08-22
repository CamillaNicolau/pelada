<?php

class PeladaRepositorio extends Pelada {
  
  /**
   * Adicionar as informações aramazenadas nos atributos do objeto no banco de dados.
   *
   * @return boolean
   */
  public function adicionaPelada(Pelada $Pelada) {

        if($Pelada->idPelada){
           echo("Método adicionaPelada() utilizado em objeto que já é instância de usuário válido.");
        } 
        try {
          $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->insert('pelada')
               ->setValue('nome', ':nome')
               ->setValue('descricao', ':descricao')
               ->setValue('duracaoPartida', ':duracaoPartida')
               ->setValue('qtJogadores', ':qtJogadores')
               ->setValue('sorteio', ':sorteio')
               ->setValue('dataPartida', ':dataPartida')
               ->setValue('fk_localizacao',':fk_localizacao')
               ->setValue('fk_usuario',':fk_usuario')
               ->setValue('dataCriacao',':dataCriacao')
               ->setParameter(':nome', $Pelada->nome)
               ->setParameter(':descricao', $Pelada->descricao)
               ->setParameter(':duracaoPartida', $Pelada->duracaoPartida)
               ->setParameter(':qtJogadores', $Pelada->qtJogadores)
               ->setParameter(':sorteio', $Pelada->sorteio)
               ->setParameter(':dataPartida',$Pelada->dataPartida)
                ->setParameter(':fk_localizacao', $Pelada->localizacao)
               ->setParameter(':fk_usuario', $Pelada->fkUsuario)
               ->setParameter(':dataCriacao',$Pelada->dataCriacao)
               ->execute()
            ;  
          $Pelada->idPelada = $QueryBuilder->getConnection()->lastInsertId();
          return $Pelada->idPelada;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Pelada");
        }   
    }
    /**
     * Salva as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @access public
     * @return string
     */
    public function atualizarPelada(Pelada $Pelada)
    {
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->update('pelada')
                ->set('nome', ':nome')
                ->set('descricao', ':descricao')
                ->set('duracaoPartida', ':duracaoPartida')
                ->set('qtJogadores', ':qtJogadores')
                ->set('sorteio', ':sorteio')
                ->set('dataPartida', ':dataPartida')
                ->setParameter(':nome', $Pelada->nome)
                ->setParameter(':descricao', $Pelada->descricao)
                ->setParameter(':duracaoPartida', $Pelada->duracaoPartida)
                ->setParameter(':qtJogadores', $Pelada->qtJogadores)
                ->setParameter(':sorteio', $Pelada->sorteio)
                ->setParameter(':dataPartida', $Pelada->dataPartida)
                ->where('idPelada = :idPelada')
                ->setParameter(':idPelada', $Pelada->idPelada)
                ->execute()
            ;
        } catch (\Exception $j) {
            echo("Um erro ocorreu ao salvar um conteudo da pelada no banco de dados - " . $j->getMessage());
        }
    }
  
    /**
     * Deleta o registro no banco de dados .
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function deletarPelada(Pelada $Pelada) {
        
        if (!$Pelada->idPelada) {
            echo('Tentativa de deletar do banco de dados um registro inexistente.');
        }
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->delete('pelada')
                ->where('idPelada = :idPelada')
                ->setParameter(':idPelada', $Pelada->idPelada, \PDO::PARAM_INT)
                ->execute()
            ; 
        } catch (\Exception $j) {
            echo($j->getMessage());
        }
        return true;
    }
    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     * 
     * @param array $condicoes
     * @param type $order
     * @param type $inicio
     * @param type $limite
     * @return array
     */
    public static function buscarPelada(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('pelada')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao buscar pelada". $j->getMessage());
        }
    }
    
}