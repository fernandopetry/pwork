<?php

namespace PWork\Directory;

/**
 *         
 * 
 *     Classe: DirectoryCreate
 *     @filesource DirectoryCreate.php
 *     @package PWork
 *     @subpackage Directory
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 12:24:38
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class DirectoryCreate {

    /**
     * Modo de permissão para o diretório
     * @var integer
     */
    private $mode = 0755;

    /**
     * Criar pastas recursivamente
     * @var boolean
     */
    private $recursive = false;

    /**
     * Pasta a ser criada
     * @var string
     */
    private $folder;

    /**
     * Renomear a pasta caso o mesmo nome já exista
     * @var boolean
     */
    private $renameIsExists = false;

    /**
     * Método construtor
     * @param string $folder Path completo da pasta a ser criada
     */
    public function __construct($folder) {
        $this->folder = $folder;
    }

    /**
     * Criar um diretório
     * @return boolean
     * @throws \Exception
     */
    public function create() {
        if (is_dir($this->folder)):
            throw new \Exception('O diretório (' . $this->folder . ') já existe!',E_USER_ERROR);
        else:
            return mkdir($this->folder, $this->mode, $this->recursive);
        endif;
    }

}
