<?php

namespace PWork\Url;

/**
 *     Faz o rotemento de uma URL e faz inclusão de arquivos
 * 
 *     Padrão de URL: www.site.com.br/pasta/arquivo/sessao
 * 
 *     Esta classe depende do seguinte código .htaccess
 * 
  <IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,L]
  </IfModule>      
 * 
 *     Classe: UrlRouter
 *     @filesource UrlRouter.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 14:17:41
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class UrlRouter {
    private $router = false;
    private $path_info='';

    /**
     * Método construtor
     * @param string $includeRootInclude Pasta raiz para inclusão dos arquivos
     */
    public function __construct() {

        $this->prepareRouter();
    }

    private function prepareRouter() {
        $pathInfo = filter_input(INPUT_SERVER, 'PATH_INFO');
        
        if (is_null($pathInfo)) {
            $pathInfo = (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : null;
        } else {
            $pathInfo = $pathInfo . '/';
            $pathInfo = str_replace('//', '/', $pathInfo);
        }

        if (is_null($pathInfo)) {
            $pathInfo = (isset($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : null;
        } else {
            $pathInfo = $pathInfo . '/';
            $pathInfo = str_replace('//', '/', $pathInfo);
        }

        // removendo a barra final se houver
        $final = str_split($pathInfo);
        $end = end($final);
        $reset = reset($final);

        if ($end == '/') {
            $pathInfo = substr($pathInfo, 0, -1);
        }

        // removendo a barra inicial se houver
        if ($reset == '/') {
            $pathInfo = substr($pathInfo, 1);
        }

        // separando os parametros em array
        $this->router = (!is_null($pathInfo)) ? explode('/', $pathInfo) : false;
//        var_dump($this->router);
        if ($this->router) {
            foreach ($this->router as $key => $value) {
                $this->router[$key] = (isset($this->router[$key])) ? $this->router[$key] : false;
                
                $this->path_info .= $value.'/';
            }
        }
    }
    
    public function getPathInfo() {
        return $this->path_info;
    }

    
    /**
     * Recupera um router expecifico
     * @param integer $param parametro da URL
     */
    public function getRouter($param) {
//        var_dump($this->router);
        if (isset($this->router[$param])) {
            if ($this->router[$param] != 'null') {
                return $this->router[$param];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
