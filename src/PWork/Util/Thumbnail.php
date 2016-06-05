<?php

namespace PWork\Util;

/**
 *         
 * 
 *     Classe: Thumbnail
 *     @filesource Thumbnail.php
 *     @package Expression project.name is undefined on line 12, column 19 in Templates/Scripting/PHPClass.php.
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 11/05/2016 18:51:40
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Thumbnail {

    public static $path;
    public static $url;

    /**
     * Gera uma thumbnail com cache
     * @param string $pathImage Path completo da imagem
     * @param integer $width Largura do thumb
     * @param integer $heigth Altura do thumb
     * @return string
     * @throws \Exception
     */
    public static function thumb($pathImage, $width, $heigth) {
        
        
        $extension = pathinfo($pathImage, PATHINFO_EXTENSION);
        $generate_name = md5($pathImage . $width . $heigth).'.'.$extension;
        
//        var_dump($generate_name,$extension);

        if (!file_exists($pathImage)) {
            throw new \Exception('Imagem não localizada!', E_USER_ERROR);
        }
        
        // Criando a pasta base se não existir
        if(!is_dir(self::$path)){
            if (!mkdir(self::$path, 0775, true)) {
                throw new \Exception('Opss, pasta de thumb não localizado e não foi possível criar.',E_USER_ERROR);
            }
        }
        

        $path = self::$path . DIRECTORY_SEPARATOR . $generate_name;

        if (file_exists($path)) {
            return self::$url . '/' . $generate_name;
        } else {
            self::generateThumb($pathImage, $generate_name, $width, $heigth);

            // ISSO NÂO ESTÁ CERTO, REESCRITA DE CÓDIGO... REFATORAR URGENTE
            if (file_exists($path)) {
                return self::$url . '/' . $generate_name;
            } else {
                throw new \Exception('Não foi possivel gerar a thumb!', E_USER_ERROR);
            }
        }
    }

    private static function generateThumb($path, $name, $width, $heigth) {
        $save = self::$path.DIRECTORY_SEPARATOR.$name;
        
        $thumb = \Canvas::Instance();
        $thumb->carrega($path);
        $thumb->redimensiona($width, $heigth, 'crop');
        $thumb->grava($save);
    }

}
