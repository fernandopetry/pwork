<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: Input
 *     @filesource Input.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 25/04/2016 17:42:47
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
abstract class Input {
    private $label;
    private $type;
    private $class;
    private $name;
    private $id;
    private $placeholder;
    private $help;
    private $value;
    private $readonly;
    
    public function getLabel() {
        return $this->label;
    }

    public function getType() {
        return $this->type;
    }

    public function getClass() {
        return $this->class;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return (is_null($this->id)) ? $this->name : $this->id;
    }

    public function getPlaceholder() {
        return $this->placeholder;
    }

    public function getHelp() {
        return $this->help;
    }

    public function getValue() {
        return $this->value;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setClass($class) {
        $this->class .= $class;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setHelp($help) {
        $this->help = $help;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function isReadOnly(){
        $this->readonly = 'readonly';
        return $this;
    }

    public function isDateTime(){
        $this->class .= ' js_datetime ';
        return $this;
    }

    public function isCoin(){
        $this->class .= ' js_coin ';
        return $this;
    }

    protected function input(){
        $type = (is_null($this->type)) ? 'text' : $this->type;
        $class = (is_null($this->class)) ? '' : $this->class;
        $name = (is_null($this->name)) ? 'undefined' : $this->name;
        $id = $this->getId();
        $placeholder = (is_null($this->placeholder)) ? '' : $this->placeholder;
        $value = (is_null($this->value)) ? '' : $this->value;
        
        
        $inputText = <<<TEXTT
              <input type="{$type}" class="form-control {$class}" name="{$name}" id="{$id}" placeholder="{$placeholder}" value="{$value}" {$this->readonly} >  
TEXTT;
        return $inputText;
    }
    
    protected function label(){
        return (is_null($this->label)) ? '' : '<label for="'.$this->getId().'">'.$this->label.'</label>';
    }

    protected function help(){
        return (is_null($this->help)) ? '' : '<p class="help-block">'.$this->help.'</p>';
    }

}
/*
<!-- 
* label
* type
* class
* name
* id
* placeholder
* help
-->
*/