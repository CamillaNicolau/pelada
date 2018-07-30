<?php

/**
 * Classe para criar a conexão no banco de dados utilizando a biblioteca DBAL do Doctrine.
 *
 * @author Camilla Nicolau
 * @version 1.0
 * @copyright 2018
 * @see http://doctrine-dbal.readthedocs.org/en/latest/reference/query-builder.html
 * @see http://www.doctrine-project.org/api/dbal/2.5/index.html
 */

class Doctrine {
    /**
     * É utilizada para verificar se a mesma encontra-se instanciada ou não.
     * 
     * @var Doctrine\DBAL\Connection
     */
    private static $instance;
    
    /**
     * Porta para a conexão no banco
     */
    const PORTA = 3306;
    
    /**
     * Codificação dos caracteres
     */
    const CHARSET = 'utf8';
    
    /**
     * Driver utilizado para fazer a conexão com o banco
     */
    const DRIVER = 'pdo_mysql';
    
    /**
     * Metodo construtor privado, para evitar que ele seja instanciado com "new Doctrine()" 
     * ao invés de Doctrine::getInstancia
     */
    private function __construct() {
        //Nada a fazer.
    }
    
    /**
     * Método estático para instanciar a classe, garantindo que ela seja instanciada apenas uma vez.
     *
     * @param array $acessaDB Array com configurações de acesso a um banco remoto
     * @return Doctrine\DBAL\Connection
     */
    public static function getInstance($remote_database=false)
    {
        if($remote_database)
        {
            return self::getUniqueInstance(
                $remote_database['bd_name'],
                $remote_database['bd_user'],
                $remote_database['bd_pass'],
                $remote_database['bd_host'],
                $remote_database['bd_port']
            );
        }

        if (!self::isInstantiated()) {
            self::setInstance(self::buildInstace());
        }
        return self::$instance;
    }
    
    /**
     * Requisita um objeto independende de conexão.
     *
     * @param string $nomeBD Nome do banco de dados
     * @param string $usuarioBD Uusário do banco de dados
     * @param string $senhaBD Senha do usuário do banco de dados
     * @param string $hostBD Host do banco de dados
     * @param int $portaBD Porta do host do banco de dados
     * @param bool $persistenciaBD Conexão persistente
     * @return Doctrine\DBAL\Connection
     */
    public static function getUniqueInstance(
      $bd_name = null, 
      $bd_user = null, 
      $bd_pass = null, 
      $bd_host = null, 
      $bd_port = self::PORTA, 
      $bd_persistent = null
    )
    {
        return self::buildInstace($bd_name, $bd_user, $bd_pass, $bd_host, $bd_port, $bd_persistent);
    }
    
    /**
     * Define uma instancia.
     *
     * @param Doctrine\DBAL\Connection $Connection
     * @return void
     */
    private static function setInstance(Doctrine\DBAL\Connection $Connection)
    {
        self::$instance = $Connection;
    }
    
    /**
     * Verifica se existe uma instancia do Doctrine.
     *
     * @return bool
     */
    public static function isInstantiated()
    {
        return self::$instance instanceof Doctrine\DBAL\Connection;
    }
    
    /**
     * Cria uma instância do DriverManager com os parametros definidos.
     *
     * @param string $nomeBD Nome do banco de dados
     * @param string $usuarioBD Uusário do banco de dados
     * @param string $senhaBD Senha do usuário do banco de dados
     * @param string $hostBD Host do banco de dados
     * @param int $portaBD Porta do host do banco de dados
     * @param bool $persistenciaBD Conexão persistente
     * @return Doctrine\DBAL\DriverManager
     * @see Doctrine\DBAL\DriverManager.php
     * @see Doctrine\DBAL\Configuration.php
     * @see Doctrine\DBAL\Logging\EchoSQLLogger.php
     */
    private static function buildInstace(
      $bd_name = null, 
      $bd_user = null, 
      $bd_pass = null, 
      $bd_host = null, 
      $bd_port = self::PORTA, 
      $bd_persistent = null
    )
    {
        $Configuration = new Doctrine\DBAL\Configuration();

        if (BD_DEBUG) {
            $Logger = new Doctrine\DBAL\Logging\EchoSQLLogger();
            $Configuration->setSQLLogger($Logger);
        }

        $connectionParams = [];
        $connectionParams['host'] = (!is_null($bd_host) ? $bd_host : BD_HOST);
        $connectionParams['dbname'] = (!is_null($bd_name) ? $bd_name : BD_NAME);
        $connectionParams['user'] = (!is_null($bd_user) ? $bd_user : BD_USER);
        $connectionParams['password'] = (!is_null($bd_pass) ? $bd_pass : BD_PASS);
        $connectionParams['persistent'] = (!is_null($bd_persistent) ? $bd_persistent : BD_PERSISTENT);
        $connectionParams['port'] = $bd_port;
        $connectionParams['charset'] = self::CHARSET;
        $connectionParams['driver'] = self::DRIVER;

        $Connection = Doctrine\DBAL\DriverManager::getConnection($connectionParams, $Configuration);
        switch (self::DRIVER) {
            case 'pdo_mysql':
                $Connection->setFetchMode(\PDO::FETCH_OBJ);
                break;
            case 'mysqli':
                $Connection->setFetchMode(\PDO::FETCH_ASSOC);
                break;
        }
        return $Connection;
    }
    /**
     * Inicia uma transaction no objeto presente na classe
     *
     * @return void
     * @see Doctrine\DBAL\Connection.php
     */
    public static function beginTransaction()
    {
        if (!self::isInstantiated()) {
            self::setInstance(self::buildInstace());
        }
        self::$instance->beginTransaction();
    }

    /**
     * Commita uma transaction no objeto presente na classe
     *
     * @return void
     * @see Doctrine\DBAL\Connection.php
     */
    public static function commit()
    {
        if (!self::isInstantiated()) {
            throw new Excecao('Não é possível fazer commit sem uma instância ativa de conexão do Doctrine na classe');
        }
        self::$instance->commit();
    }

    /**
     * Faz rollback de uma transaction em caso de erro
     *
     * @return void
     * @see Doctrine\DBAL\Connection.php
     */
    public static function rollBack()
    {
        if (!self::isInstantiated()) {
            throw new Excecao('Não é possível fazer commit sem uma instância ativa de conexão do Doctrine na classe');
        }
        self::$instance->rollBack();
    }
}
