<?php

namespace PWork\Database;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Classe abstrata para seleção de dados no banco de dados
 *     
 *     Classe: Select
 *     @filesource Select.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 29/10/2015 16:58:03
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
abstract class SelectAbstract implements iCRUD {

    /**
     * Instrução SQL completa 
     * @var string
     */
    private $sql;

    /**
     * Intrução SQL sem o LIMIT
     * @var string
     */
    private $sqlClean;

    /**
     * Lista de bindValues
     * @var \petry\database\Data
     */
    private $bindValue;

    /**
     * Lista de filtros a ser adicionado a instrução
     * @var array
     */
    private $filters;

    /**
     * Lista de Operados da expressao do tipo: WHERE, AND e OR
     * @var array 
     */
    private $expressionOperator;

    /**
     * Instrução order by
     * @var string
     */
    private $orderBy = null;

    /**
     * Instrução LIMIT
     * @var sting
     */
    private $limitString = null;

    /**
     * Limit da consulta
     * @var integer
     */
    private $limit;

    /**
     * Offset da consulta
     * @var integer
     */
    private $offset;

    /**
     * Conexao com o banco de dados
     * @var \PDO
     */
    private $pdo;

    /**
     * Metodo construtor
     * @param string $sql SQL inicial, exemplo: SELECT * FROM TABELA
     */
    public function __construct(\PDO $pdo, $sql) {
        $this->pdo = $pdo;
        $this->sql = $sql;
    }

    /**
     * Valor de limite da consulta
     * @return integer
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * Valor de offset da consulta
     * @return integer
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * Filtro básico para pesquisa
     * @param \petry\database\Data $filter Instancia de Data
     * @param string $operator Operador da instrução
     */
    protected function filter(Data $filter, $operator = 'AND') {

        // na primeira vez precisamos trocar o operador por um where
        if (empty($this->filters)) {
            $operator = "WHERE";
        }

        $this->filters[] = $filter;
        $this->expressionOperator[] = $operator;
    }

    /**
     * Registra o bindValue
     * @param \petry\database\Data $bindValue Instancia de bindValue
     * @return \petry\database\Select
     */
    private function setBindValue(Data $bindValue) {
        $this->bindValue[] = $bindValue;
        return $this;
    }

    /**
     * Gera a instrução SQL completa
     * @return string
     */
    private function getSqlInternal() {

        if (!empty($this->filters)) {
            foreach ($this->filters as $i => $filter) {

                if ('IS NULL' == $filter->getValue()) {
                    // prepara sql
                    $this->sql .= ' ' . $this->expressionOperator[$i] . ' (' . $filter->getVariable() . ' IS NULL )';
                } elseif ('IS NOT NULL' == $filter->getValue()) {
                    // prepara sql
                    $this->sql .= ' ' . $this->expressionOperator[$i] . ' (' . $filter->getVariable() . ' IS NOT NULL )';
                } else {
                    // prepara sql
                    $this->sql .= ' ' . $this->expressionOperator[$i] . ' (' . $filter->getVariable() . ' ' . $filter->getOperator() . ' :' . $filter->getReference() . ')';
                    $this->setBindValue($filter);
                }

                /*
                  // prepara sql
                  $this->sql .= ' ' . $this->expressionOperator[$i] . ' (' . $filter->getVariable() . ' ' . $filter->getOperator() . ' :' . $filter->getReference() . ')';

                  // set bindValue
                  $this->setBindValue($filter);
                  //                echo \petry\util\Helper::dump($filter,'getSqlInterval -> Loop');
                 */
            }
        }

        $this->sql = str_replace("  ", " ", $this->sql);

        $this->sql = $this->sql . $this->orderBy;

        return $this->sql;
    }

    /**
     * Registra um order by
     * @param string $variable Nome da variavel
     * @param string $position Posição de exibicao: ASC ou DESC
     */
    protected function setOrderBy($variable, $position = "ASC") {

        $this->orderBy = ' ORDER BY ';

        if ($variable == "RAND") {
            $this->orderBy .= 'RAND';
        } else {
            $this->orderBy .= $variable . ' ' . $position;
        }
    }

    /**
     * Registra o limit da consulta
     * @param integer $limit Limite de resultados por página
     * @param integer $offset Offset da consulta
     */
    protected function setLimit($limit, $offset = null) {

        // SET O LIMIT E OFFSET
        $this->limit = (int) $limit;
        $this->offset = (is_null($offset)) ? null : (int) $offset;

        // "... LIMIT 10 OFFSET 15"
        // GERANDO A STRING
        $this->limitString = " LIMIT " . (int) $limit;


        if (!is_null($offset)) {
            $this->limitString .= " OFFSET " . (int) $offset;
        }
    }

    /**
     * Executa a consulta com o banco de dados
     * @param type $customSql SQL Personalizado
     * @return array
     */
    protected function run($customSql = false) {

//        var_dump($this->filters);

        $SQLFull = $this->getSqlInternal();

        // SQL completo
        $sql = $customSql ? $customSql . '  ' . $this->limitString : $SQLFull . '  ' . $this->limitString;
        $this->sql = $sql;



        // SQL sem LIMIT
        $sqlClean = $customSql ? $customSql : $SQLFull;
        $this->sqlClean = $sqlClean;

//        var_dump($sql);
        $consult = $this->pdo->prepare($sql);

        // - verifica a existencia de filtros e aplica se houver
        if ($this->bindValue) {
//            var_dump($this->bindValue);
            foreach ($this->bindValue as $value) {
                if ('LIKE' == $value->getOperator()) {
                    $consult->bindValue(":" . $value->getReference(), "%" . $value->getValue() . "%", $value->getType());
                } else {
                    $consult->bindValue(':' . $value->getReference(), $value->getValue(), $value->getType());
                }
//                var_dump('bindValue(:'.$value->getVariable().','.$value->getValue().','.$value->getType().');');
            }
        }

        // - executa a consulta
        $consult->execute();
        return $consult->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Intrução SQL sem o LIMIT aplicado
     * @return string
     */
    public function getSqlNoLimit() {
        return $this->sqlClean;
    }

    /**
     * Listagem do bindValue
     * @return \petry\database\Data
     */
    public function getBindValue() {
        return $this->bindValue;
    }

    /**
     * Instrução SQL completa
     * @return string
     */
    public function getSql() {
        return $this->sql;
    }

}
