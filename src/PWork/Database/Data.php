<?php

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Data
 *     @filesource Filter.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 29/10/2015 11:39:06
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */

namespace PWork\Database;

class Data {

    private $variable;
    private $operator;
    private $value;
    private $type;
    private $reference;

    /**
     * Método construtor
     * @param string $variable Nome da variavel
     * @param mixed $value Valor
     * @param string $operator Operador para UPDATE, DELETE E SELECT
     */
    public function __construct($variable, $value, $operator='=') {
        $this->variable = $variable;
        $this->operator = $operator;
        $this->value = $value;
        $this->setType();
        $this->setReference($variable);
    }

    public function getVariable() {
        return $this->variable;
    }

    public function getOperator() {
        return $this->operator;
    }

    public function getValue() {
        return $this->value;
    }

    private function setType() {
        if (is_string($this->value)) {
            $this->type = \PDO::PARAM_STR;
        } elseif (is_bool($this->value)) {
            $this->type = \PDO::PARAM_BOOL;
        } elseif (is_null($this->value)) {
            $this->type = \PDO::PARAM_NULL;
        } elseif (is_int($this->value)) {
            $this->type = \PDO::PARAM_INT;
        } elseif (is_numeric($this->value)) {
            $this->type = \PDO::PARAM_INT;
        } else {
            $this->type = \PDO::PARAM_STR;
        }
    }

    public function getType() {
        return $this->type;
    }

    public function getReference() {
        return $this->reference;
    }

    private function setReference($reference) {
        $this->reference = str_replace('.', '_', $reference);
        return $this;
    }

    public function dump() {
        return "({$this->variable} {$this->operator} :{$this->value})";
    }

}
