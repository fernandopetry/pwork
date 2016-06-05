<?php

namespace PWork\Util;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Helper
 *     @filesource Helper.class.php
 *     @package PLATAZ
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 17/01/2016 12:30:59
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Helper {

    /**
     * Pega uma Url Completa
     *
     * @version v1.2
     * @return string URL completa
     */
    public static function urlFull() {
        $server = $_SERVER['SERVER_NAME'] . "/";
//        $server = filter_input(INPUT_SERVER, 'SERVER_NAME') . "/";
        $address = $_SERVER['REQUEST_URI'];

//        $address = filter_input(INPUT_SERVER, 'REQUEST_URI');

        $full = $server . $address;
        $full = str_replace("//", "/", $full);
        $full = str_replace("\\", "/", $full);

        $protocol = "http://";
//        $https = $_SERVER['HTTPS'];
//        $https = filter_input(INPUT_SERVER, 'HTTPS');
//         if( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ){
        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
//        if (isset($https) && $https == 'on') {
            $protocol = "https://";
        }

        $url = $protocol . $full;
        return $url;
    }

    /**
     * Gera uma URL completa baseado em um path
     * @param string $path Path a ser tranformado em URL completa
     * @return string
     */
    public static function urlByPath($path) {
        $url = new \PWork\Url\UrlGenerate($path);
        return $url->getURL();
    }

    /**
     * URL Exists
     *
     * Verifica se o caminho URL existe.
     * Isso é útil para verificar se um arquivo de imagem num 
     * servidor remoto antes de definir um link para o mesmo.
     *
     * @param string $url           O URL a verificar.
     *
     * @return boolean
     */
    public static function urlExists($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($code == 200); // verifica se recebe "status OK"
    }

    /**
     * Redirecionamento de páginas
     *
     * @param string $url URL destino     	
     * @param integer $time Tempo para redirecionar quando o tipo é HTML	
     * @param boolean $isHtml true = redirecionamento HTML & false = redirecionamento php
     */
    public static function redirect($url, $time = 2, $isHtml = true) {
        if ($isHtml) {
            echo '<meta http-equiv="refresh" content="' . $time . ';url=' . $url . '">';
        } else {
            header("Location: " . $url);
        }
        exit(0);
    }

    /**
     * Estrutura de uma tabela
     * @param \PDO $database Conexao PDO
     * @param string $table Nome da tabela
     * @return array Exemplo:
     * 
     * array (size=8) 
      0 => <br>
      array (size=6)<br>
      'Field' => string 'user_id' (length=7)<br>
      'Type' => string 'bigint(20)' (length=10)<br>
      'Null' => string 'NO' (length=2)<br>
      'Key' => string 'PRI' (length=3)<br>
      'Default' => null<br>
      'Extra' => string '' (length=0)<br>
     */
    public static function databaseDescribe(\PDO $database, $table) {
        try {
            // - conexao
            $pdo = $database;

            $select = $pdo->prepare("DESCRIBE " . $table);
            $select->execute();

            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * Executa um <pre>
     * @param mixed $pre Valor a ser executado no pre
     * @return string
     */
    public static function dump($pre, $titulo = '') {
        $p = '<hr />';
        $p .= '<h2>' . $titulo . '</h2>';
        $p .= '<pre>';
        $p .= print_r($pre, true);
        $p .= '</pre>';
        $p .= '<hr />';
        return $p;
    }

    /**
     * Recupera um $_POST com o filter_input
     * @param string $param Parametro esperado do $_POST
     * @return string
     */
    public static function post($param) {
        return filter_input(INPUT_POST, $param);
    }

    /**
     * Função para remover acentos de uma string
     *
     * @autor Thiago Belem <contato@thiagobelem.net>
     * @param $string string a ser removido os acentos
     * @param $slug   string separador da nova string
     */
    public static function removeAccents($string, $slug = "-") {

        $Format = array();
        $Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $Data = strtr(utf8_decode($string), utf8_decode($Format['a']), $Format['b']);
        $Data = strip_tags(trim($Data));
        $Data = str_replace(' ', $slug, $Data);
        $Data = str_replace(array(
            str_repeat($slug, 6),
            str_repeat($slug, 5),
            str_repeat($slug, 4),
            str_repeat($slug, 3),
            str_repeat($slug, 2)), $slug, $Data);

        return strtolower(utf8_encode($Data));

        
        /*


          $string = utf8_decode($string);
          $string = strtolower($string);

          //$string = str_replace( " " , $slug , $string );

          $string = preg_replace("/[ÁÀÂÃªáàâã]/i", "a", $string);
          $string = preg_replace("/[ÈÉÂèéâ]/i", "e", $string);
          $string = preg_replace("/[ÒÓóòô]/i", "o", $string);
          $string = preg_replace("/[Çç]/i", "c", $string);
          $string = preg_replace("/[ÒÓóòô]/i", "o", $string);

          var_dump($string);

          // Código ASCII das vogais
          $ascii['a'] = range(224, 230);
          $ascii['e'] = range(232, 235);
          $ascii['i'] = range(236, 239);
          $ascii['o'] = array_merge(range(242, 246), array(240, 248));
          $ascii['u'] = range(249, 252);

          // Código ASCII dos outros caracteres
          $ascii['b'] = array(223);
          $ascii['c'] = array(231);
          $ascii['d'] = array(208);
          $ascii['n'] = array(241);
          $ascii['y'] = array(253, 255);

          foreach ($ascii as $key => $item) {
          $acentos = '';
          foreach ($item AS $codigo)
          $acentos .= chr($codigo);
          $troca[$key] = '/[' . $acentos . ']/i';
          }

          $string = preg_replace(array_values($troca), array_keys($troca), $string);

          // Slug?
          if ($slug) {
          // Troca tudo que não for letra ou número por um caractere ($slug)
          $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
          // Tira os caracteres ($slug) repetidos
          $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
          $string = trim($string, $slug);
          }

          return $string;
         * 
         */
    }

    /**
     * Exclui um arquivo do disco
     * @param string $file Path completo do arquivo
     * @return booelam
     */
    public static function fileDelete($file) {
        if (file_exists($file)) {
            return unlink($file);
        } else {
            return;
        }
    }

    /**
     * Criar arquivo se não existir
     * @param string $file Caminho completo do arquivo
     * @param conteudo $content Conteudo do arquivo
     */
    public static function fileCreate($file, $content = '') {
        $return = false;
        if (!file_exists($file)) {
//            echo 'tentou criar '.$file.'<br />';
            $fileOpen = fopen($file, 'w+');
            $return = $fileOpen;
            fwrite($fileOpen, $content);
            fclose($fileOpen);
        }
        return $return;
    }

    /**
     * Recupera um icone do tipo "fa fa-icon" mas sem o "fa"
     * @param string $mimetypeOrExtension Mimetype do arquivo, ou extensao, ou simplemente o nome do arquivo
     * @return string
     */
    public static function iconFAByMimetypeOrExtension($mimetypeOrExtension) {

        $extension = false;
        $partials = explode('.', $mimetypeOrExtension);
        if (isset($partials[1]) && !strpos($mimetypeOrExtension, "/")) {
            $extension = end($partials);
        }

        $list['image/jpeg'] = 'fa-file-image-o';
        $list['image/gif'] = 'fa-file-image-o';
        $list['image/png'] = 'fa-file-image-o';
        $list['jpg'] = 'fa-file-image-o';
        $list['png'] = 'fa-file-image-o';
        $list['gif'] = 'fa-file-image-o';

        $list['application/pdf'] = 'fa-file-pdf-o';
        $list['pdf'] = 'fa-file-pdf-o';

        $list['audio/mpeg'] = 'fa-file-audio-o';
        $list['mp3'] = 'fa-file-audio-o';
        $list['wma'] = 'fa-file-audio-o';
        $list['wave'] = 'fa-file-audio-o';

        $list['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'] = 'fa-file-excel-o';
        $list['xls'] = 'fa-file-excel-o';
        $list['xlsx'] = 'fa-file-excel-o';

        $list['application/vnd.oasis.opendocument.text'] = 'fa-file-word-o';
        $list['application/msword'] = 'fa-file-word-o';
        $list['odt'] = 'fa-file-word-o';
        $list['doc'] = 'fa-file-word-o';
        $list['docx'] = 'fa-file-word-o';

        $list['application/zip'] = 'fa-file-archive-o';
        $list['application/x-rar'] = 'fa-file-archive-o';
        $list['rar'] = 'fa-file-archive-o';
        $list['zip'] = 'fa-file-archive-o';

        $list['ppt'] = 'fa-file-powerpoint-o';
        $list['pptx'] = 'fa-file-powerpoint-o';

        $list['mp4'] = 'fa-file-movie-o';
        $list['mkv'] = 'fa-file-movie-o';

        $list['html'] = 'fa-file-code-o';
        $list['text/xml'] = 'fa-file-code-o';
        $list['xml'] = 'fa-file-code-o';

        $list['text/plain'] = 'fa-file-text';
        $list['txt'] = 'fa-file-text';

//        $list[''] = '';

        if ($extension) {
            $key = $extension;
        } else {
            $key = $mimetypeOrExtension;
        }

        if (array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return 'fa-xing';
        }
    }

    /**
     * URL Router
     * @param integer $param Parametro
     * @return string
     */
    public static function router($param) {
        $router = new \PWork\Url\UrlRouter();
        return $router->getRouter($param);
    }

    /**
     * Limita a quantidade de caracter
     * @param $text  - Texto que deseja limitar a quantidade de caracter
     * @param $limit - Quantidade de caracter a ser exibido
     * @param $smash - Opção para quebrar o texto ou esperar terminar uma palavra
     */
    public static function limitedCharacter($text, $limit, $smash = true) {
        $size = strlen($text);

        // Verifica se o tamanho do texto é menor ou igual ao limite
        if ($size <= $limit) {
            $newTXT = $text;
            // Se o tamanho do texto for maior que o limite
        } else {
            // Verifica a opção de quebrar o texto
            if ($smash == true) {
                $newTXT = trim(substr($text, 0, $limit)) . '...';
                // Se não, corta $texto na última palavra antes do limite
            } else {
                // Localiza o útlimo espaço antes de $limite
                $lastSpace = strrpos(substr($text, 0, $limit), ' ');
                // Corta o $texto até a posição localizada
                $newTXT = trim(substr($text, 0, $lastSpace)) . '...';
            }
        }

        // Retorna o valor formatado
        return $newTXT;
    }

    /**
     * Gerar &HorizontalLine; (—) por x vezes
     * @param integer $x Quantidade de vezes
     * @return string
     */
    public static function htmlGenerateHorizontalLine($x) {
        $horizontalLine = '';
        for ($i = 0; $i < $x; $i++) {
            $horizontalLine .= '&HorizontalLine; ';
        }
        return $horizontalLine;
    }

}
