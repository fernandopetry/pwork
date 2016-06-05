<?php

namespace PWork\Upload;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Classe responsavem em capturar o tamanho maximo permitido de upload pelo servidor
 *     
 *     Classe: PHPUploadMaxSize
 *     @filesource PHPUploadMaxSize.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 26/11/2015 12:40:15
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class PHPUploadMaxSize {

    protected static function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remova os caracteres não-unitários (não numericos) do tamanho.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remova os caracteres não-numéricos a partir do tamanho.
        if ($unit) {
            // Encontre a posição da unidade na seqüência ordenada que é o poder de magnitude a se multiplicar por um kilobyte.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    // 
    // 
    /**
     * Retorna um limite de tamanho de arquivo em bytes baseado no upload_max_filesize PHP
     * and post_max_size
     * 
     * @staticvar integer $max_size
     * @return float
     */
    protected static function fileUploadMaxSize() {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = self::parseSize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    /**
     * Recupera o tamanho maximo de upload permitido pelo servidor em bytes
     * @return float
     */
    public static function getByBytes() {
        return self::fileUploadMaxSize();
    }

    /**
     * Recupera o tamanho maximo de upload permitido pelo servidor em Mega
     * @return float
     */
    public static function getByMegaBytes() {
        return self::fileUploadMaxSize() / 1024 / 1024;
    }

}

################################################################################
## FORMA 02
################################################################################
if (false) {
    echo '<hr />';

    //This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)  
    function convertPHPSizeToBytes($sSize) {
        if (is_numeric($sSize)) {
            return $sSize;
        }
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch (strtoupper($sSuffix)) {
            case 'P':
                $iValue *= 1024;
            case 'T':
                $iValue *= 1024;
            case 'G':
                $iValue *= 1024;
            case 'M':
                $iValue *= 1024;
            case 'K':
                $iValue *= 1024;
                break;
        }
        return $iValue;
    }

    function getMaximumFileUploadSize() {
        return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    var_dump(getMaximumFileUploadSize());
}

################################################################################
## FORMA 03 - SIMPLES
################################################################################
if (false) {
    echo '<hr />';

    $maxUpload = (int) (ini_get('upload_max_filesize'));
    $maxPost = (int) (ini_get('post_max_size'));

    var_dump($maxUpload, $maxPost);
}