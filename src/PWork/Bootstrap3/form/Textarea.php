<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: Textarea
 *     @filesource Textarea.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 26/04/2016 10:01:13
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Textarea implements iComponent {

    private $name;
    private $value;
    private $label;
    private $rows = 5;
    private $class;
    private $id;
    private $help;

    /**
     * Método construtor
     * @param string $name Nome do campo
     * @param string $value Valor do campo
     * @param string $label Legenda do campo
     */
    public function __construct($name, $value, $label) {
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
    }

    public function setRows($rows) {
        $this->rows = $rows;
        return $this;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setHelp($help) {
        $this->help = $help;
        return $this;
    }

    private function getId() {
        if (is_null($this->id)) {
            $this->id = $this->name;
        }
        return $this->id;
    }
    private function getLabelString() {
        if(!is_null($this->label)){
            return '<label class="control-label">'.$this->label.'</label>';
        }
        return $this->label;
    }
    private function getHelpString() {
        if(!is_null($this->help)){
            return '<p class="help-block">'.$this->help.'</p>';
        }
        return $this->help;
    }

        /**
     * Define o campo com um editor de texto
     * @return \PWork\Bootstrap3\form\Textarea
     */
    public function isEditor() {
        $this->class .= ' ckeditor ';
        return $this;
    }

    /**
     * Componente formatado
     * @return string
     */
    public function getComponent() {
        $component = '<div class="form-group">';
        $component .= $this->getLabelString();
        $component .= '<textarea rows="'.$this->rows.'" class="form-control '.$this->class.'" name="'.$this->name.'" id="'.$this->getId().'" >'.$this->value.'</textarea>';
        $component .= $this->getHelpString();
        $component .= '</div>';

        return $component;
    }

}

/*
<div class="form-group">
    <label class="control-label">Autogrow Textarea</label>
    <textarea rows="5" class="form-control ckeditor" name="auto" id="auto" ></textarea>
    <p class="help-block">Example block-level help text here.</p>
</div>
*/