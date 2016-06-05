<?php

namespace PWork\Menu;

/**
 *         
 * 
 *     Classe: MenuItem
 *     @filesource MenuItem.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 18/04/2016 14:25:00
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class MenuItem {

    private $legend;
    private $subLegend;
    private $href;
    private $icon;
    private $class;

    /** @var MenuItem Submenu */
    private $sub;

    /**
     * Método construtor
     * @param string $legend Legenda/Titulo do menu
     * @param string $href Destino do link
     * @param string $icon Icone
     */
    public function __construct($legend, $href, $icon = '') {
        $this->legend = $legend;
        $this->href = $href;
        $this->icon = $icon;
    }

    public function getLegend() {
        return $this->legend;
    }

    public function getHref() {
        return $this->href;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getClass() {
        return $this->class;
    }

    public function getSub() {
        return $this->sub;
    }

    public function getSubLegend() {
        return $this->subLegend;
    }

    public function setSubLegend($subLegend) {
        $this->subLegend = $subLegend;
        return $this;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function addSub(MenuItem $sub) {
        $this->sub[] = $sub;
        return $this;
    }

}
