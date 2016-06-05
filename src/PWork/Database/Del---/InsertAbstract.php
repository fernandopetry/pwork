<?php

namespace PWork\Database;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Classe abstrata para inserção de dados no banco de dados
 *     
 *     Classe: Insert
 *     @filesource Insert.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 03/11/2015 12:59:02
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
abstract class InsertAbstract implements iCRUD {

    /**
     * Lista de dados para inserção no banco de dados
     * @var \petry\database\Data
     */
    private $data = false;

    /**
     * Nome da tabela no banco de dados
     * @var string
     */
    private $table;

    /**
     * Instrução SQL
     * @var string
     */
    private $sql;

    /**
     * Conexao com o banco de dados
     * @var \PDO
     */
    private $database;
    
    /**
     * PDOStatement
     * @var \PDOStatement
     */
    private $PDOStatement;

    /**
     * Método construtor
     * @param \PDO $database Conexao com o banco de dados
     * @param string $table Nome da tabela
     */
    public function __construct(\PDO $database, $table) {
        $this->database = $database;
        $this->table = $table;
        $this->sql = "INSERT INTO {$this->table}";
        
        if(empty($this->table)){
            throw new \Exception('Atenção Desenvolvedor: Não foi localizado o nome da tabela',E_USER_ERROR);
        }
    }

    /**
     * Registra dados para inserção
     * @param \petry\database\Data $data Data de inserção
     * @return \petry\database\Insert
     */
    protected function setData(Data $data) {
        $this->data[] = $data;
        return $this;
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
            $prepare[] = $data->getVariable();
        }

        $prepare = "(:" . implode(',:', $prepare) . ")";
        return $prepare;
    }

    /**
     * Recupera a instrução SQL completa final
     * @return string
     */
    private function getSql() {
        $sql = $this->sql . " " . $this->getColmns() . " VALUES " . $this->getValues();
        return $sql;
    }
    
    /**
     * Recupera o estado do PDOStatement após a inserção
     * @return \PDOStatement
     */
    public function getPDOStatement() {
        return $this->PDOStatement;
    }

    public function setPDOStatement(\PDOStatement $PDOStatement) {
        $this->PDOStatement = $PDOStatement;
        return $this;
    }
    
    /**
     * Executa a gravação dos dados no banco de dados
     * @return boolem
     */
    protected function run() {
        try {

            $sql = $this->getSql();

//            var_dump($this->data);
//            var_dump($sql);
            
            $insert = $this->database->prepare($sql);
            foreach ($this->data as $data) {
                $insert->bindValue(':' . $data->getVariable(), $data->getValue(), $data->getType());
            }
            
            $execute = $insert->execute();
            
            $this->setPDOStatement($insert);
            
            return $execute;
        } catch (\PDOException $exc) {
            echo $exc->getMessage();
        }
    }
    
    /**
     * Recupera a instancia de conexao
     * @return \PDO
     */
    public function getConnection(){
        return $this->database;
    }

}

/*

 INSERT INTO table_name (column1, column2, column3,...)
VALUES (value1, value2, value3,...) 

*/