<?php

namespace PWork\Upload;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Image
 *     @filesource Image.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 26/11/2015 11:13:56
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Image extends Upload implements iUpload {

    private $detination;
    private $info;
    private $width;
    private $height;

    /**
     * Método construtor
     * @param array $Files Files do arquivo. Ex.: $_FILES['arquivo']
     * @param string $destination Path completo do destino do arquivo
     * @param mixed $customRename Nome customizado para o arquivo
     */
    public function __construct($Files, $destination, $customRename = false) {
        parent::__construct($Files, $destination, $customRename);

        $this->detination = parent::getDestination() . '/' . parent::getNewName();

        $this->info = getimagesize(parent::getTmpName());

    }

    /**
     * Executa o upload do arquivo
     * @return boolean
     */
    public function execute() {

        $this->width = \Local\Config::$cms_image_width;
        $this->height = \Local\Config::$cms_image_heigth;
            
        if (\Local\Config::$cms_image_size_reverse_direction) {
            if ($this->info[0] < $this->info[1]) {
                $this->width = \Local\Config::$cms_image_heigth;
                $this->height = \Local\Config::$cms_image_width;
            }
        }

        $upload = \Canvas::Instance(parent::getTmpName());
        $upload->redimensiona($this->width, $this->height, \Local\Config::$cms_image_type);
        return $upload->grava($this->detination);
    }

}
