<?php

namespace PWork\Util;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: DateTime
 *     @filesource tDateTime.class.php
 *     @package PLATAZ
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 17/01/2016 22:57:25
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class DateTime {

    static $timezone = 'America/Sao_Paulo';

    /**
     * Transforma data e hora do formato Brasileiro para o formato EUA
     * @param datetime $datetime Data e Hora no formato Brasileiro
     * @param type $format Opcional, formato de retorno no padrão PHP
     * @return string
     */
    public static function dateTimeTransformBRforEUA($datetime, $format = 'Y-m-d H:i:s') {
        $date = new \DateTime(str_replace('/', '-', $datetime));
        $date->setTimezone(new \DateTimeZone(self::$timezone));
        return $date->format($format);
    }

    /**
     * Transforma data e hora do formato EUA para o formato Brasileiro
     * @param datetime $datetime Data e Hora no formato EUA
     * @param string $format Opcional, formato de retorno no padrão PHP
     * @return string
     */
    public static function dateTimeTransformEUAforBR($datetime, $format = 'd/m/Y H:i:s') {
        $date = new \DateTime($datetime);
        $date->setTimezone(new \DateTimeZone(self::$timezone));
        return $date->format($format);
    }

}
