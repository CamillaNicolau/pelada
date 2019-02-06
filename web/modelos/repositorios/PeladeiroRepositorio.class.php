<?php

/**
 * Description of PeladeiroRepositorio
 *
 * @author Camilla Nicolau
 */
class PeladeiroRepositorio extends Peladeiro {
    /**
   * Adicionar as informações aramazenadas nos atributos do objeto no banco de dados.
   *
   * @return boolean
   */
  public function adicionaPeladeiro(Peladeiro $Peladeiro) {

        if($Peladeiro->idPeladeiro){
           echo("Método adicionaPeladeiro() utilizado em objeto que já é instância de usuário válido.");
        } 
        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder(); 
            $QueryBuilder
                ->insert('usuario')
                ->setValue('nome', ':nome')
                ->setValue('email', ':email')
                ->setValue('telefone', ':telefone')
                ->setValue('data_nascimento', ':data_nascimento')
                ->setValue('url_imagem', ':url_imagem')
                ->setValue('participacao', ':participacao')
                ->setValue('fk_criador', ':fk_criador')
                ->setValue('fk_marcacoes',':fk_marcacoes')
                ->setValue('fk_time_futebol',':fk_time_futebol')
                ->setValue('fk_posicao',':fk_posicao')
                ->setValue('senha',':senha')
                ->setParameter(':nome', $Peladeiro->nome)
                ->setParameter(':email', $Peladeiro->email)
                ->setParameter(':telefone', $Peladeiro->telefone)
                ->setParameter(':data_nascimento', $Peladeiro->data_nascimento)
                ->setParameter(':url_imagem', $Peladeiro->url_imagem)
                ->setParameter(':participacao', $Peladeiro->participacao)
                ->setParameter(':fk_criador',$Peladeiro->usuario)
                ->setParameter(':fk_marcacoes', $Peladeiro->marcacoes)
                ->setParameter(':fk_time_futebol', $Peladeiro->timeFutebol)
                ->setParameter(':fk_posicao', $Peladeiro->posicao)
                ->setParameter(':senha', $Peladeiro->senha)
                ->execute()
            ;  
          $Peladeiro->idPeladeiro = $QueryBuilder->getConnection()->lastInsertId();
          return $Peladeiro->idPeladeiro;
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Pelada" . $ex);
        }   
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
    public static function buscarPeladeiro(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('usuario')
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
            echo ("Erro ao buscar peladeiro". $j->getMessage());
        }
    }
    public function atualizarPeladeiro(Peladeiro $Peladeiro) {

        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder(); 
            $QueryBuilder
                ->update('usuario')
                ->set('nome', ':nome')
                ->set('email', ':email')
                ->set('telefone', ':telefone')
                ->set('data_nascimento', ':data_nascimento')
                ->set('url_imagem', ':url_imagem')
                ->set('participacao', ':participacao')
                ->set('fk_criador', ':fk_criador')
                ->set('fk_marcacoes',':fk_marcacoes')
                ->set('fk_time_futebol',':fk_time_futebol')
                ->set('fk_posicao',':fk_posicao')
                ->setParameter(':nome', $Peladeiro->nome)
                ->setParameter(':email', $Peladeiro->email)
                ->setParameter(':telefone', $Peladeiro->telefone)
                ->setParameter(':data_nascimento', $Peladeiro->data_nascimento)
                ->setParameter(':url_imagem', $Peladeiro->url_imagem)
                ->setParameter(':participacao', $Peladeiro->participacao)
                ->setParameter(':fk_criador',$Peladeiro->usuario)
                ->setParameter(':fk_marcacoes', $Peladeiro->marcacoes)
                ->setParameter(':fk_time_futebol', $Peladeiro->timeFutebol)
                ->setParameter(':fk_posicao', $Peladeiro->posicao)
                ->where('id_usuario = :id_usuario')
                ->setParameter(':id_usuario', $Peladeiro->idPeladeiro)
                ->execute()
            ;  
        } catch (Exception $ex) {
            echo("'Erro ao adicionar Peladeiro" . $ex);
        }   
    }
    /**
     * Deleta o registro no banco de dados .
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function deletarPeladeiro(Peladeiro $Peladeiro) {
        
        if (!$Peladeiro->idPeladeiro) {
            echo('Tentativa de deletar do banco de dados um registro inexistente.');
        }
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->delete('usuario')
                ->where('id_usuario = :id_usuario')
                ->setParameter(':id_usuario', $Peladeiro->idPeladeiro)
                ->execute()
            ; 
        } catch (\Exception $j) {
            echo($j->getMessage());
        }
       return true;
    }
    
    /**
     * insere o registro no banco de dados .
     *
     */
    public function inserirGrupoPeladeiro($peladeiro,$parceiro) {
        
        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder(); 
            $QueryBuilder
                ->insert('parceiro')
                ->setValue('fk_peladeiro', ':fk_peladeiro')
                ->setValue('fk_parceiro', ':fk_parceiro')
                ->setParameter(':fk_peladeiro', $peladeiro, \PDO::PARAM_INT)
                ->setParameter(':fk_parceiro', $parceiro, \PDO::PARAM_INT)
                ->execute()
            ;  
        } catch (\Exception $e26811) {
            echo('Erro ao adicionar na classe '.__CLASS__.': '.$e26811->getMessage());
        }
        return true;
    }
    
    public static function buscarGrupoPeladeiro(array $condicoes = [], $order = false, $inicio = null, $limite = null) {
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('u.id_usuario','u.nome','u.email')
                ->from('parceiro','p')
                ->join('p','usuario','u','p.fk_peladeiro = u.id_usuario')
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
            echo ("Erro ao buscar peladeiro". $j->getMessage());
        }
    }
}
