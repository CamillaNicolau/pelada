<?php

/**
 * Listagem com as cidades registradas no banco
 *
 * @author Camilla Nicolau <camillacoelhonicolau@gmail>
 * @version 1.0
 * @copyright 2019 
 */
class CidadeRepositorio extends Cidade {
    
    /**
     * Realiza a listagem com as cidades registradas no banco de acordo com os parametros informados.
     *
     * @param int $id_cidade Parametro para determinar o registro da cidade.
     * @param string $nome Parametro para determinar o registro do nome.
     * @param int $estado Parametro para determinar o registro do estado.
     * @param string $order Parametro e o tipo de ordenação desejado. Exemplos: "id DESC", "nome ASC".
     * @param int $inicio Parametro para determinar o registro inicial da listagem.
     * @param int $limite Quantidade de registros para listagem.
     * @return array Retorna um array com as cidades.
     */
    
    public static function buscarCidade($id_cidade = null, $nome = null, $estado = null, $order = false, $inicio = null, $limite = null){
        try {

            $QueryBuilder = \Doctrine::getInstance()->createQueryBuilder();
            $QueryBuilder
                ->select('*')
                ->from('cidade')
            ;
            if ($estado) {
                $QueryBuilder
                    ->where('fk_estado = :fk_estado')
                    ->setParameter(':fk_estado', $estado);
            }
            if (isset($inicio)) {
                $QueryBuilder->setFirstResult($inicio);
            }
            if (isset($limite)) {
                $QueryBuilder->setMaxResults($limite);
            }
            
            return $QueryBuilder->execute()->fetchAll();
        } catch (Exception $j){
            echo ("Erro ao buscar cidade ". $j->getMessage());
        }
    }
}
