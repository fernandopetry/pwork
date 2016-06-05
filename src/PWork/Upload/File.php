<?php

namespace PWork\Upload;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: File
 *     @filesource File.class.php
 *     @package NC-TRANSPARENCIA
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 26/11/2015 11:13:32
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class File extends Upload implements iUpload {
    
    /**
     * Método construtor
     * @param array $Files Files do arquivo. Ex.: $_FILES['arquivo']
     * @param string $destination Path completo do destino do arquivo
     * @param mixed $customRename Nome customizado para o arquivo
     */
    public function __construct($Files, $destination,$customRename=false) {
        parent::__construct($Files, $destination,$customRename);
    }

    /**
     * Executa o upload do arquivo
     * @return boolean
     */
    public function execute() {
        $destination = parent::getDestination();
        
        $destinationFull = $destination . '/' . parent::getNewName();
        
        if(move_uploaded_file(parent::getTmpName(), $destinationFull)){
            return true;
        }else{
            return false;
        }
    }

}
