<?php

namespace PWork\Util;

/**
 *         
 * 
 *     Classe: DataController
 *     @filesource DataController.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 28/04/2016 19:37:39
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
abstract class DataController {

    protected $data;
    protected $type;

    public function __construct($data, $type = 'insert') {
        $this->data = $data;
        $this->type = $type;

        $this->clean();
    }

    private function clean() {
        foreach ($this->data as $key => $value) {
            if (!is_array($value)) {
                $this->data[$key] = trim($value);
                $this->data[$key] = filter_var($this->data[$key]);
                // removendo as quebras de linhas
                $this->data[$key] = preg_replace("/\s/", " ", $this->data[$key]);
                $this->data[$key] = preg_replace("/\r\n/", " ", $this->data[$key]);
                $this->data[$key] = preg_replace("/\n/", " ", $this->data[$key]);
            }
        }
    }

    /**
     * Remove chaves desnecessárias
     * @param array $keys Array com as chaves a serem removidas
     */
    protected function removeKeys(array $keys) {
//        var_dump($keys);
        foreach ($keys as $key) {
            unset($this->data[$key]);
        }
    }

    protected abstract function getData();
}
