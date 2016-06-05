<?php

namespace PWork\File;

/**
 *         
 * 
 *     Classe: FileDelete
 *     @filesource FileDelete.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 13:04:33
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class FileDelete {

    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function run() {
        if (file_exists($this->file) && is_file($this->file)):
            return unlink($this->file);
        else:
            return null;
        endif;
    }

}
