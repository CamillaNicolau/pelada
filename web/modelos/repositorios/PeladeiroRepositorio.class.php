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
                ->insert('peladeiro')
                ->setValue('nome', ':nome')
                ->setValue('email', ':email')
                ->setValue('telefone', ':telefone')
                ->setValue('data_nascimento', ':data_nascimento')
                ->setValue('url_imagem', ':url_imagem')
                ->setValue('participacao', ':participacao')
                ->setValue('fk_usuario', ':fk_usuario')
                ->setValue('fk_marcacoes',':fk_marcacoes')
                ->setValue('fk_time_futebol',':fk_time_futebol')
                ->setValue('fk_posicao',':fk_posicao')
                ->setParameter(':nome', $Peladeiro->nome)
                ->setParameter(':email', $Peladeiro->email)
                ->setParameter(':telefone', $Peladeiro->telefone)
                ->setParameter(':data_nascimento', $Peladeiro->data_nascimento)
                ->setParameter(':url_imagem', $Peladeiro->url_imagem)
                ->setParameter(':participacao', $Peladeiro->participacao)
                ->setParameter(':fk_usuario',$Peladeiro->usuario)
                ->setParameter(':fk_marcacoes', $Peladeiro->marcacoes)
                ->setParameter(':fk_time_futebol', $Peladeiro->timeFutebol)
                ->setParameter(':fk_posicao', $Peladeiro->posicao)
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
                ->from('peladeiro')
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
