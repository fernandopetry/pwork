<?php

namespace PWork\Init;

/**
 *     Inicialização do sistema    
 * 
 *     Classe: Init
 *     @filesource Init.php
 *     @package PWork
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 07/04/2016 20:31:44
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandosouza2@gmail.com>                                                  
 */
class Init {

    private $isProduction = false;
    private $phpVersionMininal = 5.5;

    public function setPhpVersionMininal($phpVersionMininal) {
        $this->phpVersionMininal = $phpVersionMininal;
    }

    public function isProduction() {
        $this->isProduction = true;
    }

    public function setSessionMaxlifetime($param) {
        # Alterando o tempo de duração de uma sessão
        ini_set('session.gc_maxlifetime', $param);
    }

    public function run() {
        
        # Ativa a compactação das páginas
        if(function_exists('ob_start')):
            ob_start('ob_gzhandler');
        endif;
        
        # Diz para o PHP que estamos usando strings UTF-8 até o final do script
        if (function_exists('mb_internal_encoding')):
            mb_internal_encoding('UTF-8');
        endif;

        # Diz para o PHP que nós vamos enviar uma saída UTF-8 para o navegador
        if (function_exists('mb_http_output')):
            mb_http_output('UTF-8');
        endif;

        # Definindo o header como utf-8
        header('Content-Type: text/html; charset=utf-8');

        # Inicialização de variaveis e constantes independentes
        $_isError = false;

        define("DS", DIRECTORY_SEPARATOR);
        define("E_USER_SUCCESS", 'success');

        # ID da sessão
        define('SESSION_ID', session_id());

        # Inicializa a sessão se não existir
        if (empty(SESSION_ID)):
            session_start();
        endif;

        # Alterando o local de armazenamento das sessões do sistema
        if (!is_writable(ini_get('session.save_path'))):
            echo "<hr />O diretorio padrão para armazenamento das sessões não tem permissão de escrita: " . ini_get('session.save_path') . "<br /><hr />";
        endif;

        if (function_exists("ini_get")):
            # Habilitanto o UTF-8
            ini_set('default_charset', 'UTF-8');

            # Configuração para desenvolvimento: 
            # Ativando e desativando exibicao de erros
            if ($this->isProduction):
                ini_set('display_errors', 0);
                ini_set('display_startup_erros', 0);
                error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            else:
                ini_set('display_errors', 1);
                ini_set('display_startup_erros', 1);
                error_reporting(E_ALL);
            endif;
        endif;

        //==============================================================================
        // Verifica magic_quotes_runtime() e desabilita se necessário
        //==============================================================================
        // http://br.php.net/manual/pt_BR/ref.info.php#ini.magic-quotes-runtime
        /* Se magic_quotes_runtime  estiver ativado, a maioria das funções 
         * que retornarem dados de qualquer fonte externa incluindo banco de dados e
         * arquivos de texto terão as aspas escapadas com uma barra invertida. 
         * Se magic_quotes_sybase  também estiver em on, uma aspa simples é escapada com 
         * uma aspa simples ao invés de uma barra invertida. */
        if (get_magic_quotes_runtime()) {
            set_magic_quotes_runtime(0);
        }

        if (ini_get("magic_quotes_sybase")):
            ini_set("magic_quotes_sybase", 0);
        endif;

        /* remove os efeitos das magic_quote diferente do runtime 
         * ele escapa dados vindos de formularios, GPC (Get/Post/Cookie), 
         * isso nao pode ser auterado via php.ini, 
         * por isso consertamos aqui, no PHP7 nao teremos mais magic_quotes */

        function remove_mq(&$var) {
            return is_array($var) ? array_map("remove_mq", $var) : stripslashes($var);
        }

        //verifico se esta em on e execulto a função acima
        if (get_magic_quotes_gpc()) {
            $_GET = array_map("remove_mq", $_GET);
            $_POST = array_map("remove_mq", $_POST);
            $_COOKIE = array_map("remove_mq", $_COOKIE);
        }

        //==============================================================================
        // REGISTROS GLOBAIS
        //==============================================================================
        if (ini_get("register_globals")):
            foreach ($GLOBALS as $s_variable_name => $m_variable_value):
                if (!in_array($s_variable_name, array("GLOBALS", "argv", "argc", "_FILES", "_COOKIE", "_POST", "_GET", "_SERVER", "_ENV", "_SESSION", "s_variable_name", "m_variable_value"))):
                    unset($GLOBALS[$s_variable_name]);
                endif;
            endforeach;
            unset($GLOBALS["s_variable_name"]);
            unset($GLOBALS["m_variable_value"]);
        endif;

        //==============================================================================
        // clearstatcache — Limpa as informações em cache sobre arquivos
        //==============================================================================
        //http://br.php.net/manual/pt_BR/function.clearstatcache.php
        clearstatcache();

        //==============================================================================
        // DEFINIÇÕES DE DATETIME
        //==============================================================================
        # Definindo o timezone para localidade de São Paulo
        date_default_timezone_set('America/Sao_Paulo');

        # Definindo o local para o horário do sistema
        setlocale(LC_ALL, 'pt_BR');

        //==============================================================================
        // VERIFICANDO A VERSAO MINIMA DO PHP PARA RODAR O SISTEMA
        //==============================================================================
        if (version_compare(PHP_VERSION, $this->phpVersionMininal, '<')) {
            echo 'O sistema exige que a versão do PHP seja de ' . $this->phpVersionMininal . ' ou superior, sua versão é: ' . PHP_VERSION . "\n";
            exit(0);
        }
    }

}
