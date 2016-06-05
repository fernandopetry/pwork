<?php

/* * *
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Connection
 *     @filesource Connection.class.php
 *     @package app_core
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 06/10/2015 06/10/2015 13:45:27
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */

namespace PWork\Database;

require_once dirname(__FILE__) . '/iConnection.php';

abstract class Connection implements iConnection {

    /**
     * Nome do servidor
     * @var string
     */
    private $server;

    /**
     * Usuario de acesso ao banco de dados
     * @var string
     */
    private $user;

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    private $password;

    /**
     * Nome do banco de dados
     * @var string
     */
    private $database;

    public function getServer() {
        return $this->server;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function setServer($server) {
        $this->server = $server;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setDatabase($database) {
        $this->database = $database;
        return $this;
    }

}
