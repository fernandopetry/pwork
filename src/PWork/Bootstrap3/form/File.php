<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: File
 *     @filesource File.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 19/05/2016 14:53:03
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class File implements iComponent {
    private $name;
    private $id;
    private $isMultiple;
    private $label;
    
    public function __construct($name, $label) {
        $this->name = $name;
        $this->label = $label;
    }
    
    public function isMultiple(){
        $this->isMultiple = 'multiple=""';
        return $this;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getComponent() {
        if(is_null($this->id)){
            $this->id = $this->name;
        }
        
        $res = '<div class="form-group">';
        $res .= '<label for="'.$this->name.'" >'.$this->label.'</label>';
//        $res .= '<div class="col-lg-12">';
        $res .= '<input type="file" '.$this->isMultiple.' name="'.$this->name.'" id="'.$this->id.'">';
//        $res .= '</div>';
        $res .= '</div>';

        return $res;
    }

}

/*
<div class="form-group">
    <label for="example-file-input" class="col-xs-12">File Input</label>
    <div class="col-xs-12">
        <input type="file" name="example-file-input" id="example-file-input">
    </div>
</div>

---------------------------------

<div class="form-group">
    <label for="example-file-multiple-input" class="col-xs-12">Multiple File Input</label>
    <div class="col-xs-12">
        <input type="file" multiple="" name="example-file-multiple-input" id="example-file-multiple-input">
    </div>
</div>

*/