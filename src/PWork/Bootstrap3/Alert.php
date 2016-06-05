<?php

namespace PWork\Bootstrap3;

/**
 *    Alertas em HTML com a resposta baseada no bootstrap 3
 *                                                   
 *     > 
 *     
 *     Classe: Alert
 *     @filesource Alert.class.php
 *     @package PWork
 *     @subpackage Bootstrap3
 *     @category
 *     @version v1.0
 *     @since 18/03/2016 15:25:29
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Alert {

    /**
     * Mensagem de alerta
     * @param string $message Mensagem a ser exibida
     * @param string $code Tipo de mensagem: E_USER_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_DEPRECATED, E_USER_SUCCESS
     * @param string $messageAdditional Mensagem adicional a ser exibida abaixo da mensagem principal, caracteres HMTL são aceitos
     * @return string
     */
    public static function run($message, $code, $messageAdditional = null) {

        switch ($code):
            case E_USER_ERROR:
                $errorType = 'danger';
                $title = 'Erro!';
                break;
            case E_USER_NOTICE:
                $errorType = 'info';
                $title = 'Informação!';
                break;
            case E_USER_WARNING;
                $errorType = 'warning';
                $title = 'Aviso!';
                break;
            case E_USER_DEPRECATED;
                $errorType = 'info';
                $title = 'Obsoleto!';
                break;
            case E_USER_SUCCESS;
                $errorType = 'success';
                $title = 'Sucesso!';
                break;
            case 0:
                $errorType = 'danger';
                $title = 'Erro!';
                break;
            default :
                $errorType = 'danger';
                $title = 'Erro!';
        endswitch;


        $Mess = <<<ERR
    <div class="alert alert-{$errorType} alert-dismissable">
        <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
        <h3 class="font-w300 push-15">{$title}</h3>
        <p>  <a class="alert-link" href="javascript:void(0)">{$message}</a>!</p>
        {$messageAdditional}
    </div>        
ERR;
        return $Mess;
    }

}
