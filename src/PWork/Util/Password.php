<?php

namespace PWork\Util;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Gerenciamento de senhas
 *     
 *     Classe: Password
 *     @filesource Password.class.php
 *     @package PLATAZ
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 17/01/2016 22:44:20
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Password {

    /**
     * Gera uma senha com a api do PHP 5.5
     * @link http://php.net/password_hash Documentação do PHP 
     * @param string $password Senha a ser codificada
     * @return string
     */
    public static function passwordGenerate($password) {
        return password_hash(trim($password), PASSWORD_DEFAULT, ['cost' => 11]);
    }

    /**
     * Verifica uma senha com o hash salvo no banco de dados
     * @link http://php.net/password_verify Documentação do PHP 
     * @param string $password Senha a ser verificada
     * @param string $hash Hash salvo para comparar com a senha
     * @return boolean
     */
    public static function passwordVerify($password, $hash) {
        return password_verify(trim($password), $hash);
    }
    
    /**
     * Função para gerar senhas aleatórias
     *
     * @author Thiago Belem <contato@thiagobelem.net>
     *        
     * @param integer $size Tamanho da senha a ser gerada
     * @param boolean $uppercase Se terá letras maiúsculas
     * @param boolean $numbers Se terá números
     * @param boolean $symbols Se terá símbolos
     *        	
     * @return string A senha gerada
     */
    public static function passwordAutoGenerator($size = 8, $uppercase = true, $numbers = true, $symbols = false) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '@#$*';
        $return = '';
        $characters = '';

        $characters .= $lmin;
        if ($uppercase)
            $characters .= $lmai;
        if ($numbers)
            $characters .= $num;
        if ($symbols)
            $characters .= $simb;

        $len = strlen($characters);
        for ($n = 1; $n <= $size; $n ++) {
            $rand = mt_rand(1, $len);
            $return .= $characters [$rand - 1];
        }
        return $return;
    }

}
