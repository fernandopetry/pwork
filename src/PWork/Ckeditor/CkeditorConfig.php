<?php

namespace PWork\Ckeditor;

/**
 *         
 * 
 *     Classe: CkeditorConfig
 *     @filesource CkeditorConfig.php
 *     @package Ckeditor
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 08/04/2016 13:34:18
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class CkeditorConfig {

    /**
     * Path base completo do Ckeditor
     * @return string
     */
    protected static function getPathCkeditor() {
        return dirname(__FILE__);
    }

    /**
     * Path completo do script do ckeditor
     * @return string
     */
    public static function getPathCkeditorJS($onlyPath = false) {
        $path = \PWork\Util\Helper::urlByPath(self::getPathCkeditor()) . DIRECTORY_SEPARATOR . 'ckeditor.js';
        $file = '<script src="' . $path . '"></script>';
        if ($onlyPath) {
            $file =  $path;
        }
        
        return $file;
    }

    /**
     * Isto gera o script que chama o CKeditor para substituir o textarea,
     * ele deve ser inserido no final da página
     */
    public static function getCkeditorReplace() {
        $script = <<<SC
   <script type="text/javascript">
      /*window.onload = function()  {
        CKEDITOR.replace();
      };*/
                //CKEDITOR.replace();
                
                jQuery(function () {

       

        $("textarea.ckeditor").each(function () {

            var editorId = $(this).attr("id");

//                console.log(editorId);
                
             if(!editorId=='undefined'){   
                
                try {
                    var instance = CKEDITOR.instances[editorId];
                    if (instance) {
                        instance.destroy(true);
                    }

                } catch (e) {
                } finally {
                    CKEDITOR.replace(editorId);
                }
              }  
                
        });

    });
    </script>             
SC;
        return $script;
    }

}
