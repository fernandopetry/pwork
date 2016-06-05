<?php

namespace PWork\Database;

/**
 *         
 * 
 *     Classe: Insert
 *     @filesource Insert.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 28/04/2016 13:00:24
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Insert {

    /** @var \PDO Instancia de pdo */
    private $conn;
    private $table;
    private $dataTemp;

    /** @var Data Lista de data */
    private $data;
//    private $result;
//    private $insert;
    private $sql;
    
    /** @var \PDOStatement PDOStatement */
    private $PDOStatement;

    /**
     * Método construtor
     * @param \PDO $conn Conexão PDO
     * @param string $table Nome da tabela no banco de dados
     * @param array $data Array atribuitivo. ['nome_da_coluna'=>'valor']
     */
    function __construct(\PDO $conn, $table, array $data) {
        $this->conn = $conn;
        $this->table = $table;
        $this->dataTemp = $data;

        $this->generateData();

        $this->sql = "INSERT INTO {$table} ";

        $this->sql();
    }

    private function generateData() {
        foreach ($this->dataTemp as $key => $value) {
            $this->data[] = new Data($key, $value);
        }
    }

    /**
     * Recupera a conexão
     * @return \PDO Conexao PDO
     */
    public function getConn() {
        return $this->conn;
    }

    /**
     * Recupera as colunas para inserção no banco de dados. Ex: (name,email,pass)
     * @return string
     */
    private function getColmns() {
        $prepare = null;
        foreach ($this->data as $data) {
            $prepare[] = $data->getVariable();
        }

        $prepare = "(" . implode(',', $prepare) . ")";
        return $prepare;
    }

    /**
     * Recupera as referencias para inserção no banco de dados. Ex: (:name,:email,:pass)
     * @return string
     */
    private function getValues() {
        $prepare = null;
        foreach ($this->data as $data) {
            $prepare[] = $data->getReference();
        }

        $prepare = "(:" . implode(',:', $prepare) . ")";
        return $prepare;
    }

    /**
     * Recupera a instrução SQL completa final
     * @return string
     */
    private function sql() {
        $this->sql = $this->sql . " " . $this->getColmns() . " VALUES " . $this->getValues();
    }

    /**
     * Executa a gravação dos dados no banco de dados
     * @return boolem
     */
    public function run() {
        try {
            $this->PDOStatement = $this->conn->prepare($this->sql);
            foreach ($this->data as $data) {
                $this->PDOStatement->bindValue(':' . $data->getReference(), $data->getValue(), $data->getType());
            }
            return $this->PDOStatement->execute();
        } catch (\PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * GET Resultado do insert
     * @return \PDOStatement 
     */
    function getPDOStatement() {
        return $this->PDOStatement;
    }

}
