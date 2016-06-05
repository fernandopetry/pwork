<?php

namespace PWork\Database;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > Banco de dados armazenados em arquivos via jason
 *     
 *     Classe: JsonDB
 *     @filesource JsonDB.class.php
 *     @package AZControl
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 28/02/2016 16:05:26
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class JsonDB {
    
    protected $filename;
    protected $json;

    public function __construct($filename) {
        
        $this->filename = $filename;
        
        if(!file_exists($this->filename)){
            file_put_contents($this->filename, '');
        }
        
        $this->json = json_decode(file_get_contents($this->filename),true);
        
    }
    
    public function add($key,$value){
        $this->json[$key] = $value;
    }
    
    public function delete($key,$value){
        $this->json[$key] = $value;
    }
    
    public function get($key){
        return $this->json[$key];
    }
    
    public function save(){
        return file_put_contents($this->filename, json_encode($this->json));
    }

}
/*

Para isso você utiliza o file_exists, além de URL remoto ele funciona com caminhos absolutos ou relativos do próprio servidor, desta forma:

    if(file_exists('http://www.dominio.com/imagens/minha-imagem.jpg')){
       //seu código...
    }
outras funções úteis são:

is_readable - Diz se o arquivo pode ser lido.
file - Lê todo o arquivo para um array
file_get_contents - Lê todo o arquivo para uma string (extremamente útil)
fread - Leitura binary-safe de arquivo
readfile - Lê e exibe o conteúdo de um arquivo

*/