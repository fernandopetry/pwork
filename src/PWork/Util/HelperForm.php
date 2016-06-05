<?php

namespace PWork\Util;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: HelperForm
 *     @filesource HelperForm.class.php
 *     @package A-Z_GESTOR
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 24/01/2016 14:29:56
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class HelperForm {
    /**
     * Seleciona um menu select quando o valor esperado for igual o valor atual
     * @param string $value Valor esperado para a opção 
     * @param string valor_atual Valor atual do registro
     * @return string
     */
    public static function menuSelectSelected($value,$value2){
        if($value==$value2){
            return 'selected=""';
        }
    }
    /**
     * Seleciona um radio quando o valor esperado for igual o valor atual
     * @param string $value Valor esperado para a opção 
     * @param string valor_atual Valor atual do registro
     * @return string
     */
    public static function radioSelecionar($value,$value2){
        if($value==$value2){
            return 'checked=""';
        }
    }
}
