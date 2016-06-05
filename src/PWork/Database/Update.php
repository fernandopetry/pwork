<?php

namespace PWork\Database;

/**
 *         
 * 
 *     Classe: Update
 *     @filesource Update.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 29/04/2016 14:32:24
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Update {

    /**
     * Conexao PDO
     * @var \PDO
     */
    private $pdo;

    /**
     * Nome da tabela para atualização no banco de dados
     * @var string
     */
    private $table;

    /**
     * Lista de dados a ser atualizado
     * @var \petry\database\Data 
     */
    private $data;

    /**
     * Expressão do where
     * @var string 
     */
    private $where;

    /**
     * Lista de bindValues 
     * @var \petry\database\Data 
     */
    private $whereBindValue;

    /**
     * Instrução SQL para atualização 
     * @var string
     */
    private $sql;

    /**
     * Método construtor
     * @param \PDO $pdo Conexao com o banco de dados
     * @param string $table Nome da tabela no banco de dados
     */
    public function __construct(\PDO $pdo, $table, array $data) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->generateData($data);
    }

    private function generateData(array $data) {
        foreach ($data as $key => $value) {
            $data = new Data($key, $value);
            $this->data[] = $data;
            $this->whereBindValue[] = $data;
        }
    }

    /**
     * 
     * @param \petry\database\Data $data
     * @param type $operator
     * @return \petry\database\Update
     */
    protected function setWhere(Data $data, $operator = 'AND') {

        $op = (is_null($this->where)) ? ' WHERE' : ' ' . $operator . ' ';

        $this->where .= $op . ' ' . $data->getVariable() . $data->getOperator() . ' :' . $data->getVariable();
        $this->whereBindValue[] = $data;

        return $this;
    }

    /**
     * Adicionar um oou mais filtros para atualização
     * @param \petry\database\Data $data Informações do filtro
     * @param string $operator Operador
     */
    public function where(Data $data, $operator = 'AND') {
        $this->setWhere($data, $operator);
    }

    /**
     * Recupera a expressao SET do SQL
     * @return string
     */
    private function getSET() {
        $set = null;

        foreach ($this->data as $data) {
            $separator = (is_null($set)) ? 'SET ' : ',';

            $set .= $separator . $data->getVariable() . $data->getOperator() . ':' . $data->getVariable();
        }
        return $set;
    }

    /**
     * Verifica se foi enviado o WHERE da instrução
     * @throws \Exception
     */
    private function validateWhere() {
        if (is_null($this->where)) {
            throw new \Exception('ERRO Inesperado. WHERE não informado!', E_USER_ERROR);
        }
    }

    /**
     * Verifica se foi enviado os dados para atualização
     * @throws \Exception
     */
    private function validateData() {
        if (is_null($this->data)) {
            throw new \Exception('ERRO Inesperado. Nenhuma Data encontrada para atualizar!', E_USER_ERROR);
        }
    }

    /**
     * Instrução SQL finalizada
     * @return string
     */
    private function getSql() {
        $set = $this->getSET();
        return $this->sql = 'UPDATE ' . $this->table . ' ' . $set . $this->where;
    }

    /**
     * Executa a gravação no banco de dados
     * @return Booleam
     */
    public function run() {
        // validação do where
        $this->validateWhere();

        // validação da Data
        $this->validateData();

        // SQL
        $sql = $this->getSql();

//        var_dump($sql);
        // executar operação
        $update = $this->pdo->prepare($sql);

//        var_dump($this->whereBindValue);

        foreach ($this->whereBindValue as $where) {
            $update->bindValue(':' . $where->getVariable(), $where->getValue(), $where->getType());
        }
        return $update->execute();
    }

}
