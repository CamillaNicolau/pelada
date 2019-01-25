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
                ->setValue('nome_pelada', ':nome_pelada')
                ->setValue('descricao', ':descricao')
                ->setValue('duracao_pelada', ':duracao_pelada')
                ->setValue('qt_jogadores', ':qt_jogadores')
                ->setValue('sorteio', ':sorteio')
                ->setValue('data_pelada ', ':data_pelada ')
                ->setValue('fk_localizacao',':fk_localizacao')
                ->setValue('fk_peladeiro',':fk_peladeiro')
                ->setValue('horario', ':horario')
                ->setValue('data_criacao',':data_criacao')
                ->setParameter(':nome_pelada', $Pelada->nome)
                ->setParameter(':descricao', $Pelada->descricao)
                ->setParameter(':duracao_pelada', $Pelada->duracaoPartida)
                ->setParameter(':qt_jogadores', $Pelada->qtJogadores)
                ->setParameter(':sorteio', $Pelada->sorteio)
                ->setParameter(':data_pelada',$Pelada->dataPartida)
                ->setParameter(':fk_localizacao', $Pelada->localizacao)
                ->setParameter(':fk_peladeiro', $Pelada->fkPeladeiroAdm)
                ->setParameter(':horario', $Pelada->horario)
                ->setParameter(':data_criacao',$Pelada->dataCriacao)
                ->execute()
            ;  
          $Pelada->idPelada = $QueryBuilder->getConnection()->lastInsertId();
          return $Pelada->idPelada;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Pelada" . $ex);
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
                ->set('nome_pelada', ':nome_pelada')
                ->set('descricao', ':descricao')
                ->set('duracao_pelada', ':duracao_pelada')
                ->set('qt_jogadores', ':qt_jogadores')
                ->set('sorteio', ':sorteio')
                ->set('data_pelada ', ':data_pelada ')
                ->set('fk_localizacao',':fk_localizacao')
                ->set('fk_peladeiro',':fk_peladeiro')
                ->set('horario',':horario')
                ->set('data_criacao',':data_criacao')
                ->setParameter(':nome_pelada', $Pelada->nome)
                ->setParameter(':descricao', $Pelada->descricao)
                ->setParameter(':duracao_pelada', $Pelada->duracaoPartida)
                ->setParameter(':qt_jogadores', $Pelada->qtJogadores)
                ->setParameter(':sorteio', $Pelada->sorteio)
                ->setParameter(':data_pelada',$Pelada->dataPartida)
                ->setParameter(':fk_localizacao', $Pelada->localizacao)
                ->setParameter(':fk_peladeiro', $Pelada->fkPeladeiroAdm)
                ->setParameter(':horario',$Pelada->horario)
                ->setParameter(':data_criacao',$Pelada->dataCriacao)
                ->where('id_pelada = :id_pelada')
                ->setParameter(':id_pelada', $Pelada->idPelada)
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
                ->where('id_pelada = :id_pelada')
                ->setParameter(':id_pelada', $Pelada->idPelada)
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
                ->from('pelada','p')
                ->join('p','localizacao_pelada','l','p.fk_localizacao = l.id_localizacao_pelada')
                ->join('l','cidade','c','l.fk_cidade = c.id_cidade')
                ->join('p','usuario','u','p.fk_peladeiro = u.id_usuario')
                ->join('c','estado','e','c.fk_estado = e.id_estado')
            ;
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
    public static function buscaGeralPelada(array $condicoes = [], $order = false, $inicio = null, $limite = null){

        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('pelada_peladeiro','p')
                ->join('p','pelada','pe','p.fk_pelada = pe.id_pelada')
                ->join('p','localizacao_pelada','l','pe.fk_localizacao = l.id_localizacao_pelada')
                ->join('l','cidade','c','l.fk_cidade = c.id_cidade')
                ->join('p','usuario','u','pe.fk_peladeiro = u.id_usuario')
                ->join('c','estado','e','c.fk_estado = e.id_estado')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            
            return $QueryBuilder->execute()->fetchAll();
        }
        catch (\Exception $j) {
            echo ("Erro ao buscar localizacao". $j->getMessage());
        }

    }

    /**
     * Salva os peladeiros para a pelada.
     *
     * @return bool
     */
    public function salvarPeladeiroPelada(Pelada $Pelada)
    {

        try {
            foreach ($Pelada->peladeiros as $chave=>$valor) {

                $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
                $QueryBuilder
                    ->insert('pelada_peladeiro')
                    ->setValue('fk_peladeiro', ':fk_peladeiro')
                    ->setValue('fk_pelada', ':fk_pelada')
                    ->setParameter(':fk_pelada', $Pelada->idPelada, \PDO::PARAM_INT)
                    ->setParameter(':fk_peladeiro', $chave, \PDO::PARAM_INT)
                    ->execute()
                ;

            }
         
        } catch (\Exception $e26811) {
            echo('Erro ao adicionar na classe '.__CLASS__.': '.$e26811->getMessage());
        }
               return true;

    }
    /**
     * Deleta o registro no banco de dados .
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function deletarPeladeiroPelada(array $condicoes = []) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->delete('pelada_peladeiro')
            ;
            if ($where != '') {
                $QueryBuilder->where($where);
            }
            return $QueryBuilder->execute()->fetchAll();
        } catch (\Exception $j) {
            echo($j->getMessage());
        }
    }
}