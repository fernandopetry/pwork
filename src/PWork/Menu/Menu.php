<?php

namespace PWork\Menu;

/**
 *         
 * 
 *     Classe: Menu
 *     @filesource Menu.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 18/04/2016 14:27:32
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Menu {
    /** @var MenuItem Lista de itens de menu */
    private $items;
    
    public function addMenu(MenuItem $menu) {
        $this->items[] = $menu;
    }
    
    public function getItems() {
        return $this->items;
    }
}
