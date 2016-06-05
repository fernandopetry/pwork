<?php

namespace PWork\Database;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Delete
 *     @filesource Delete.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 08/01/2016 16:38:26
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Delete {

    private $table;
    private $data;

    /**
     * Método construtor
     * @param string $table Nome da tabela
     * @param \petry\database\Data $data Filtro de Delete
     */
    public function __construct($table, Data $data) {
        $this->table = $table;
        $this->data = $data;
    }

    /**
     * Instrução SQL
     * @return string
     */
    private function sql() {
        return "DELETE FROM {$this->table} WHERE {$this->data->getVariable()} {$this->data->getOperator()} :{$this->data->getReference()}";
    }

    /**
     * Executa a exclusão no banco de dados
     * @return boolean
     */
    public function run() {
        try {
            
            $delete = connection()->prepare($this->sql());
            $delete->bindValue(':'.$this->data->getReference(), $this->data->getValue(), $this->data->getType());
            return $delete->execute();
            
        } catch (\PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}

/*
DELETE FROM table_name
WHERE some_column=some_value;
*/