<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: Text
 *     @filesource Text.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 25/04/2016 17:46:22
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Text extends Input implements iComponent {
    
    /**
     * Método construtor
     * @param string $name Nome do campo
     * @param string $value Valor do campo
     * @param string $label Legenda do campo
     */
    public function __construct($name,$value,$label) {
        parent::setName($name);
        parent::setValue($value);
        parent::setLabel($label);
        parent::setType('text');
    }

    public function isHidden() {
        parent::setType('hidden');
        return $this;
    }


    public function getComponent() {
        
        if(parent::getType()=='hidden'){
            return parent::input();
        }
        
        $res = '<div class="form-group">';
        $res .= parent::label();
        $res .= parent::input();
        $res .= parent::help();
        $res .= '</div>';
        return $res;
    }

}
/*
<div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="" id="exampleInputEmail1" placeholder="Email" value="" >
    <p class="help-block">Example block-level help text here.</p>
</div>
*/