<?php

/**
 * Gerenciar os dados a serem enviados e recebidos do banco
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019 
 */
class LocalizacaoRepositorio extends Localizacao {

    /**
     * Realiza a consulta dos registros presentes no banco de dados de acordo com os termos informados para a pesquisa.
     * 
     * @param array $condicoes
     * @param type $order
     * @param type $inicio
     * @param type $limite
     * @return array
     */
    public static function buscarLocalizacao(array $condicoes = [], $order = false, $inicio = null, $limite = null){
        
        $where = ($condicoes) ? implode(" AND ", $condicoes) : "";
        try {
            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('localizacao_pelada')
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
            echo ("Erro ao buscar localizacao". $j->getMessage());
        }
    }
    
    /**
     * Adicionar as informações aramazenadas nos atributos do objeto no banco de dados.
     *
     * @return boolean
     */
    public function adicionaLocalizacao(Localizacao $Localizacao) {
        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->insert('localizacao_pelada')
               ->setValue('nome_quadra', ':nome_quadra')
               ->setValue('rua', ':rua')
               ->setValue('bairro', ':bairro')
               ->setValue('numero', ':numero')
               ->setValue('fk_cidade', ':fk_cidade')
               ->setParameter(':nome_quadra', $Localizacao->nomeQuadra)
               ->setParameter(':rua', $Localizacao->rua)
               ->setParameter(':bairro', $Localizacao->bairro)
               ->setParameter(':numero', $Localizacao->numero)
               ->setParameter(':fk_cidade', $Localizacao->cidade) 
               ->execute()
            ;  
            $Localizacao->idLocalizacao = $QueryBuilder->getConnection()->lastInsertId();    
            return $Localizacao->idLocalizacao;
        } catch (Exception $ex) {
            echo('Erro ao adicionar na classe '.__CLASS__.': '.$ex->getMessage());
        }   
    }
    
    /**
     * Atualiza os dados do objeto no banco de dados.
     *
     * @return bool Retorna true ao final da operação com sucesso
     */
    public function atualizarLocalizacao(Localizacao $Localizacao) {     
        try {
            $QueryBuilder =  \Doctrine::getInstance()->createQueryBuilder();   
            $QueryBuilder
              ->update('localizacao_pelada')
               ->set('nome_quadra', ':nome_quadra')
               ->set('rua', ':rua')
               ->set('bairro', ':bairro')
               ->set('numero', ':numero')
               ->set('fk_cidade', ':fk_cidade')
               ->setParameter(':nome_quadra', $Localizacao->nomeQuadra)
               ->setParameter(':rua', $Localizacao->rua)
               ->setParameter(':bairro', $Localizacao->bairro)
               ->setParameter(':numero', $Localizacao->numero)
               ->setParameter(':fk_cidade', $Localizacao->cidade) 
                ->where('id_localizacao_pelada = :id_localizacao_pelada')
                ->setParameter(':id_localizacao_pelada', $Localizacao->idLocalizacao)
                ->execute();
        } catch (\Exception $j) {
            echo("Erro ao atualizar a localização- " . $j->getMessage());
        } 
    }
}
