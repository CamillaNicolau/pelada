<?php

/**
 * Controla o modelo a ser carregado.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 */
class ControlaModelos
{
    
    public function __construct ()
    {
        // Nada no método construtor.
    }
    
    /**
     * Responsável por receber o nome do modelo a ser carregado.
     * 
     * @param string $nome_modelo
     * @param bool $objeto
     * @return string || objeto
     */
	public function carregarModelo ($nome_modelo, $objeto = true)
    {
        if ($nome_modelo) {
            $caminho_modelo = PATH_RAIZ . '/modelos/servicos' . $nome_modelo . '.class.php';
            if (file_exists($caminho_modelo)) {
                require_once $caminho_modelo;
            }

			if (class_exists($nome_modelo) && $objeto) {
                return new $nome_modelo();
            } else {
                return $nome_modelo;
            }
        }
	}
    
}