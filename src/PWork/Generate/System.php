<?php

namespace PWork\Generate;

/**
 *    Classe responsável em gerar as pastas de um novo sistema
 *     
 *     Classe: System
 *     @filesource System.php
 *     @package PWork
 *     @subpackage Generate
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 10:35:50
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class System {

    /**
     * Path base da instalação do sistema
     * @var string 
     */
    private $pathBase;
    private $datetime, $year;
    private $folders;
    private $filesPartials;
    private $filesBase;

    /**
     * Método construtor
     * @param string $pathBase Path base do sistema, normalmente: dirname(__FILE__)
     */
    public function __construct($pathBase) {
        $this->pathBase = $pathBase;

        # verifica a existencia da pasta base
        if (!is_dir($this->pathBase)):
            throw new \Exception('O diretório base informado não existe, verifique: ' . $this->pathBase, E_USER_ERROR);
        endif;

        $this->datetime = date('d/m/Y H:i:s');
        $this->year = date('Y');

        //----------------------------------------------------------------------
        // Lista de pastas basicas
        //----------------------------------------------------------------------
        $this->folders = [
            $this->pathBase . DIRECTORY_SEPARATOR . 'system',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/_SQL',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/dashboard',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/dashboard/default',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/error',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/error/default',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/user',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/app/user/login',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/admin/classes',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/assets',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/assets/js',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/assets/css',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/assets/img',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/includes',
            $this->pathBase . DIRECTORY_SEPARATOR . 'system/partials',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/assets',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/assets/js',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/assets/css',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/assets/img',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/includes',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/pages',
            $this->pathBase . DIRECTORY_SEPARATOR . 'theme/default/partials',
            $this->pathBase . DIRECTORY_SEPARATOR . 'storage',
            $this->pathBase . DIRECTORY_SEPARATOR . 'storage/cache',
            $this->pathBase . DIRECTORY_SEPARATOR . 'storage/log',
            $this->pathBase . DIRECTORY_SEPARATOR . 'storage/session'
        ];

        $this->filesPartials = [
            'sidebar_base.inc.php',
            'footer_base.inc.php',
            'footer_end.inc.php',
            'footer_start.inc.php',
            'header_base.inc.php',
            'header_end.inc.php',
            'header_start.inc.php'
        ];
        $this->filesBase = [
            'index.php',
            'functions.php'
        ];
    }

    private function htmlNull() {
        $_HTML_NULL = <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <title>Acesso Restrito</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>Acesso incorreto</div>
    </body>
</html>
HTML;
        return $_HTML_NULL;
    }

    private function htaccessDenny() {
        $_HTACCESS_DENNY = <<<PWW
Options -Indexes

deny from all    
PWW;
        return $_HTACCESS_DENNY;
    }

    private function htaccessSystem() {
        $_HTACCESS_DENNY = <<<PWW
Options -Indexes

#deny from all    
PWW;
        return $_HTACCESS_DENNY;
    }

    private function htaccessIndex() {
        $_HTACCESS_INDEX = <<<PWW
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php/$1 [QSA,L]
</IfModule>   
PWW;
        return $_HTACCESS_INDEX;
    }

    private function commentPHP() {
        $comment = <<<PWW
<?php
/* * *
 *     Petry Work
 *                                                   
 *     >
 *     
 *     @filesource 
 *     @package 
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since {$this->datetime}
 *     @copyright (cc) {$this->year}, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
 
PWW;
        return $comment;
    }

    private function indexSytem() {
        $_PHP_INDEX_SYSTEM = $this->commentPHP() . '
    
// Rota padrão
// :module/:controller/:action/*
// forum  / post      / edit / 42
// user  / login     / access / 42
// user  / login     / forgot / 42
// module / controller/action/param 1
# File include
$_ROUTER_INCLUDE = false;

# Rota completa
$_ROUTER_FULL = \PWork\Helper\Path::$controller . "/" . \PWork\Helper\RouterPartials::$module . "/" . \PWork\Helper\RouterPartials::$controller . "/" . \PWork\Helper\RouterPartials::$action . ".php";

# Rota de erro
$_ROUTER_404 = \PWork\Helper\Path::$controller . DIRECTORY_SEPARATOR . "error" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "404.php";

# Dashboard
$_ROUTER_DASHBOARD = \PWork\Helper\Path::$controller . DIRECTORY_SEPARATOR . "dashboard" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "index.php";

# Validações
if (file_exists($_ROUTER_FULL)) {
    $_ROUTER_INCLUDE = $_ROUTER_FULL;
} elseif (file_exists($_ROUTER_DASHBOARD)) {
    $_ROUTER_INCLUDE = $_ROUTER_DASHBOARD;
} elseif (file_exists($_ROUTER_404)) {
    $_ROUTER_INCLUDE = $_ROUTER_404;
}

if ($_ROUTER_INCLUDE) {
    require_once $_ROUTER_INCLUDE;
} else {
    echo "<h3>Opss, sujou não encontramos nenhum  arquivo para incluir</h3>";
}
 
';
        return $_PHP_INDEX_SYSTEM;
    }

    private function phpCfg() {
        $_PHP_CFG = <<<PWW
<?php
/* * *
 *     Petry Work
 *                                                   
 *     > Arquivo de configuração de banco de dados do sistema
 *     
 *     @filesource cfg.dev.php
 *     @package Petry_Work
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since {$this->datetime}
 *     @copyright (cc) {$this->year}, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */  
 
 //==============================================================================
// ** Configurações do MySQL                                               ** //
//==============================================================================

/** Nome do host do MySQL */
define("DB_HOST", 'localhost');

/** Usuário do banco de dados MySQL */
define("DB_USERNAME", 'root');

/** Senha de acesso ao banco de dados MySQL */
define("DB_PASSWORD", '123');

/** Nome do banco de dados */
define("DB_DATABASE", '');
PWW;
        return $_PHP_CFG;
    }

    private function indexBase() {
        $_PHP_INDEX_BASE = <<<PWW
<?php
/* * *
 *     Petry Work
 *                                                   
 *     > Arquivo inicial do sistema
 *     
 *     @filesource index.php
 *     @package Petry_Work
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since {$this->datetime}
 *     @copyright (cc) {$this->year}, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */  
PWW;
 $_PHP_INDEX_BASE .= '
require_once dirname(__FILE__) . "/vendor/autoload.php";

# Funções do system
require_once dirname(__FILE__) . "/system/functions.php";

# Inicialização
$init = new \PWork\Init\Init();
//$init->isProduction();
$init->setPhpVersionMininal(5.5);
$init->setSessionMaxlifetime(10800);
$init->run();

# Registrando os paths principais
\PWork\Helper\Path::$base = dirname(__FILE__);
\PWork\Helper\Path::$storage = PWork\Helper\Path::$base."/storage";
\PWork\Helper\Path::$cache = PWork\Helper\Path::$storage."/cache";
\PWork\Helper\Path::$log = PWork\Helper\Path::$storage."/log";
\PWork\Helper\Path::$session = PWork\Helper\Path::$storage."/session";
\PWork\Helper\Path::$system = PWork\Helper\Path::$base."/system";
\PWork\Helper\Path::$controller = PWork\Helper\Path::$system."/admin/app";
\PWork\Helper\Path::$theme = PWork\Helper\Path::$base."/theme";


# Roteamento
$indexRouter = new \PWork\Url\UrlRouter();

# Gerar url baseado no path
$urlGenerate = new PWork\Url\UrlGenerate(PWork\Helper\Path::$base);

# Registrando as urls principais
\PWork\Helper\Url::$base = $urlGenerate->getURL();
\PWork\Helper\Url::$app = \PWork\Helper\Url::$base."/app";
\PWork\Helper\Url::$site = \PWork\Helper\Url::$base."/site";
\PWork\Helper\Url::$system = \PWork\Helper\Url::$base."/system";
\PWork\Helper\Url::$assets = \PWork\Helper\Url::$system."/assets";
\PWork\Helper\Url::$theme = \PWork\Helper\Url::$base."/theme";

# Registrando as partes da rota
\PWork\Helper\RouterPartials::setRouter($indexRouter);

# Redirecionando se não foi informado nenhum tipo: app ou site
//if(!\PWork\Helper\RouterPartials::$type){
//    header("Location: ".\PWork\Helper\Url::$site);
//    exit();
//}

// Rota padrão
// :module/:controller/:action/*
// forum  / post      / edit / 42
// module / controller/action/param 1

if (\PWork\Helper\RouterPartials::$type == "app"){
    require_once dirname(__FILE__) . "/system/index.php";
}else{
    require_once dirname(__FILE__) . "/theme/default/index.php";
}

';
        return $_PHP_INDEX_BASE;
    }

    private function createFolder($folder) {
        $create = new \PWork\Directory\DirectoryCreate($folder);
        if ($create->create()):
            echo 'Pasta <strong>' . $folder . '</strong> criada com sucesso! <br />';
        else:
            echo 'Opss, pasta <strong>' . $folder . '</strong> não pode ser criada! <br />';
        endif;
    }

    private function generateFolder() {
        foreach ($this->folders as $folder) {
            if (!is_dir($folder)):
                $this->createFolder($folder);
            endif;
        }
    }

    private function helperCreateFile($file, $content = '') {
        $file = new \PWork\File\FileCreate($file, $content);
        return $file->run();
    }

    private function generateFiles() {
        # Criando o arquivo principal
        $this->helperCreateFile($this->pathBase . '/index.php', $this->indexBase());

        $this->helperCreateFile($this->pathBase . '/system/index.php', $this->indexSytem());

        # Criando o arquivo .htaccess
        $this->helperCreateFile($this->pathBase . '/.htaccess', $this->htaccessIndex());

        # Criando o arquivo .htaccess
        $this->helperCreateFile($this->pathBase . '/cfg.dev.php', $this->phpCfg());

        # Index dashboard
        $this->helperCreateFile($this->pathBase . '/system/admin/app/dashboard/default/index.php', '<h3>Dashboard APP</h3>');

        $this->helperCreateFile($this->pathBase . '/system/admin/app/error/default/404.php', '<h3>ERRO 404 APP</h3>');

        $this->helperCreateFile($this->pathBase . '/system/admin/app/user/login/access.php', '<h3>LOGIN ACCESS</h3>');

        $this->helperCreateFile($this->pathBase . '/system/admin/app/user/login/forgot.php', '<h3>LOGIN FORGOT</h3>');


        # Gerando partial
        foreach ($this->filesPartials as $partial) {
            $this->helperCreateFile($this->pathBase . '/theme/default/partials/' . $partial, '<h3>' . $partial . '</h3>');
            $this->helperCreateFile($this->pathBase . '/system/partials/' . $partial, '<h3>' . $partial . '</h3>');
        }

        $this->helperCreateFile($this->pathBase . '/system/.htaccess', $this->htaccessSystem());
        $this->helperCreateFile($this->pathBase . '/storage/.htaccess', $this->htaccessDenny());
        
        foreach ($this->filesBase as $filebase) {
            $this->helperCreateFile($this->pathBase . '/theme/default/'.$filebase, '<h3>Theme Default -> ' . $filebase . '</h3>');
        }
        
        $this->helperCreateFile($this->pathBase . '/system/functions.php', '<h3>system/functions.php</h3>');
        
        $this->helperCreateFile($this->pathBase . '/theme/.htaccess', $this->htaccessDenny());


        # Gerar arquivos html para diretorios vazios
        foreach ($this->folders as $folder) {
            if (\PWork\Directory\DirectoryHelper::isEmpty($folder)):
                $this->helperCreateFile($folder . '/index.html', $this->htmlNull());
            endif;
        }
    }

    public function run() {
        $this->generateFolder();
        $this->generateFiles();
    }

}
