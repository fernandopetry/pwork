<?php

namespace PWork\File;

/**
 *         
 * 
 *     Classe: FileCreate
 *     @filesource FileCreate.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 11:56:55
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class FileCreate {

    private $mode='w+';
    private $file;
    private $content;
    
    /**
     * 
     * @param string $file Caminho completo do arquivo
     * @param conteudo $content Conteudo do arquivo
     */
    public function __construct($file,$content = '') {
        $this->file = $file;
        $this->content = $content;
    }
    
    /**
     * Criar arquivo se não existir
     */
    public function run() {
        $return = false;
        if (!file_exists($this->file)) {
            $fileOpen = fopen($this->file, $this->mode);
            $return = $fileOpen;
            fwrite($fileOpen, $this->content);
            fclose($fileOpen);
        }
        return $return;
    }

}
