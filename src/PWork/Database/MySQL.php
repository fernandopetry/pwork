<?php

/* * *
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: MySQL
 *     @filesource MySQL.class.php
 *     @package app_core
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 06/10/2015 06/10/2015 13:55:54
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */

namespace PWork\Database;

require_once dirname(__FILE__) . '/Connection.php';

class MySQL extends Connection {

    /** @var \PDO Objeto pdo */
    private static $conn = null;

    /**
     * Método construtor
     * @param string $server Nome do servidor
     * @param string $user Usuario de acesso ao servidor
     * @param string $password Senha do servidor
     * @param string $database Banco de dados de acesso
     */
    public function __construct($server, $user, $password, $database) {
        parent::setServer($server);
        parent::setUser($user);
        parent::setPassword($password);
        parent::setDatabase($database);
    }

    public function getConnection() {
        try {

            if (self::$conn == null):
                // http://br.phptherightway.com/#php_e_utf8
                $dsn = 'mysql:host=' . parent::getServer() . ';dbname=' . parent::getDatabase() .';charset=utf8mb4';
                $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');

                self::$conn = new \PDO($dsn, parent::getUser(), parent::getPassword(), $options);

                /**
                 * \PDO::ERRMODE_SILENT
                 * Esse é o tipo padrão utilizado pelo PDO, basicamente o PDO 
                 * seta internamente o código de um determinado erro, 
                 * podendo ser resgatado através dos métodos 
                 * PDO::errorCode() e PDO::errorInfo().
                 */
                /**
                 * \PDO::ERRMODE_WARNING
                 * Além de armazenar o código do erro, este tipo de manipulação de erro 
                 * irá enviar uma mensagem E_WARNING, sendo este muito utilizado durante 
                 * a depuração e/ou teste da aplicação.
                 */
                /**
                 * \PDO::ERRMODE_EXCEPTION
                 * Além de armazenar o código de erro, este tipo de manipulação de erro 
                 * irá lançar uma exceção PDOException, esta alternativa é recomendada, 
                 * principalmente por deixar o código mais limpo e legível.
                 */
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                // http://br.phptherightway.com/#php_e_utf8
                self::$conn->setAttribute(\PDO::ATTR_PERSISTENT, false);

                /**
                 * Evitando erros de acentuação
                 */
                self::$conn->query("SET NAMES 'utf8'");
                self::$conn->query("SET character_set_connection=utf8");
                self::$conn->query("SET character_set_client=utf8");
                self::$conn->query("SET character_set_results=utf8");
            endif;
            
            return self::$conn;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}
