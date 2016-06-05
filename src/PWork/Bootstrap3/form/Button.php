<?php

namespace PWork\Bootstrap3\form;

/**
 *         
 * 
 *     Classe: InputSubmit
 *     @filesource InputSubmit.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 27/04/2016 15:53:17
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Button implements iComponent {
    
    private $label='Gravar';
    function __construct($label='Gravar') {
        $this->label = $label;
    }

    public function getComponent() {
        $res = '<div class="form-group">';
        $res .=  '<button type="submit" class="btn btn-minw btn-square btn-primary"><i class="fa fa-check push-5-r"></i> '.$this->label.'</button>';
        $res .= '</div>';
        return $res;
    }

}
// <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check push-5-r"></i> Gravar</button>