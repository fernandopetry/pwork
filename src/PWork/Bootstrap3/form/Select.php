<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: Select
 *     @filesource Select.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 29/04/2016 09:30:10
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Select implements iComponent {

    private $name;
    private $data;
    private $label;
    private $id;
    private $placeholder='Selecione uma opção...';
    private $selected;
    private $class;

    /**
     * Método construtor
     * @param string $name Nome do campo
     * @param array $data Array associativo ['legenda'=>'valor',...]
     * @param string $label Legenda do campo
     */
    public function __construct($name, $data, $label) {
        $this->name = $name;
        $this->data = $data;
        $this->label = $label;
    }

    /**
     * Informe o valor que deseja que fique selecionado
     * @param string $value Valor a ficar selecionado
     */
    public function setSelected($value) {
        $this->selected = $value;
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

    private function generateOptions() {
        $option = '<option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->'.PHP_EOL;
        
        foreach ($this->data as $key => $label) {
            
            $selected = ($key==$this->selected) ? 'selected' : '';
            
            $option .= '<option value="'.$key.'" '.$selected.' >'.$label.'</option>'.PHP_EOL;
        }
        
        return $option;
    }   


    public function getComponent() {
        if (empty($this->id)) {
            $this->id = $this->name;
        }
        
        $return = '<div class="form-group">';
        $return .= '<label class="control-label" for="' . $this->name . '">' . $this->label . '</label>';
        $return .= '<select class="js_select2 form-control" id="'.$this->id.'" name="'.$this->name.'" style="width: 100%;" data-placeholder="'.$this->placeholder.'">';
        $return .= $this->generateOptions();
        $return .= '</select>';
        $return .= '</div>';
        
        return $return;
    }

}

/*
<div class="form-group">
    <label class="control-label" for="example-select2">Normal</label>
    <select class="js_select2 form-control" id="example-select2" name="example-select2" style="width: 100%;" data-placeholder="Selecione uma opção..">
        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
        <option value="1">HTML</option>
        <option value="2">CSS</option>
        <option value="3">JavaScript</option>
        <option value="4" selected >PHP</option>
        <option value="5">MySQL</option>
        <option value="6">Ruby</option>
        <option value="7">AngularJS</option>
    </select>
</div>
*/