<?php

namespace PWork\Directory;

/**
 *         
 * 
 *     Classe: DirectoryHelper
 *     @filesource DirectoryHelper.php
 *     @package PWork
 *     @subpackage Directory
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 13:29:45
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class DirectoryHelper {

    public static function isEmpty($folder) {
        $scan = scandir($folder);
        if (count($scan) > 2) {
            return false;
        } else {
            return true;
        }
    }

}
