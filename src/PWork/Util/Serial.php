<?php

namespace PWork\Util;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Gerar e validar um determinado serial
 *     
 *     Classe: Serial
 *     @filesource Serial.class.php
 *     @package AZControl
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 01/03/2016 19:37:53
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Serial {

    private static $key = 'PWork';

    /**
     * Gera um numero de serial
     * @param string $name Alguma identificação para gerar o serial
     * @return string
     */
    public static function getSerial($name = null) {
        $a = hash('crc32', self::$key);
        $b = hash('crc32', sprintf('%s%s', md5($name), md5($a)));
        $c = sscanf(sprintf('%s%s', $a, $b), '%4s%4s%4s%4s');
        $d = 1;

        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $d += pow(ord($c[$i]{ $j }), $i), $j++) {
                
            }
        }

        $c[4] = $d;

        return vsprintf('%s-%s-%s-%s-%05x', $c);
    }

    /**
     * Validação do serial
     * @param string $serial Numero do serial
     * @return string
     */
    public static function validateSerial($serial) {
        $c = sscanf($serial, '%4s-%4s-%4s-%4s');
        $d = 1;

        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $d += pow(ord($c[$i]{ $j }), $i), $j++) {
                
            }
        }

        $c[4] = $d;

        return !strcmp($serial, vsprintf('%s-%s-%s-%s-%05x', $c));
    }

}

/*

function getSerial( $name = null ){
    $a = hash( 'crc32' , 'chave secreta' );
    $b = hash( 'crc32' , sprintf( '%s%s' , md5( $name ) , md5( $a ) ) );
    $c = sscanf( sprintf( '%s%s' , $a , $b ) , '%4s%4s%4s%4s' );
    $d = 1;

    for ( $i = 0 ; $i < 4 ; $i++ )
        for ( $j = 0 ; $j < 4 ; $d += pow( ord( $c[ $i ]{ $j } ) , $i ) , $j++ );

    $c[ 4 ] = $d;

    return vsprintf( '%s-%s-%s-%s-%05x' , $c );
}

function validaSerial( $serial ){
    $c = sscanf( $serial , '%4s-%4s-%4s-%4s' );
    $d = 1;

    for ( $i = 0 ; $i < 4 ; $i++ )
        for ( $j = 0 ; $j < 4 ; $d += pow( ord( $c[ $i ]{ $j } ) , $i ) , $j++ );

    $c[ 4 ] = $d;

    return !strcmp( $serial , vsprintf( '%s-%s-%s-%s-%05x' , $c ) );
}

$serial = getSerial( 'Nome do cliente' );

if ( validaSerial( $serial ) ){
    printf( 'O serial %s é válido.' , $serial );
} else {
    print 'Serial inválido.';
}

*/