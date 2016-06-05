<?php

namespace PWork\Mail;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: Mail
 *     @filesource Mail.class.php
 *     @package AZControl
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 22/03/2016 08:22:52
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class Mail extends \PHPMailer {


    /** @var SmtpConfig Configuração SMTP */
    private $SmtpConfig;

    public function __construct(SmtpConfig $SmtpConfig) {
        
        parent::__construct($exceptions = false);

        /* Configuração do SMTP */
        $this->SmtpConfig = $SmtpConfig;
        $this->CharSet = "UTF-8";

        if ($this->SmtpConfig->getActive()) {
            $this->isSMTP();
            $this->SMTPAuth = true;
            $this->Host = $this->SmtpConfig->getHost();
            $this->Port = $this->SmtpConfig->getPort();
            $this->Username = $this->SmtpConfig->getUsername();
            $this->Password = $this->SmtpConfig->getPassword();
        } else {
            $this->isMail();
        }

        $this->setFrom($this->SmtpConfig->getFrom(), $this->SmtpConfig->getFromName());
        $this->addReplyTo($this->SmtpConfig->getReplyTo(), $this->SmtpConfig->getReplyToName());
    }

    /**
     * Enviar e-mail, antes de enviar é necessário informar: ->addAddress(), ->Subject, ->msgHTML()
     * @throws \Exception
     * @throws Exception
     */
    public function send() {
        
        if(empty($this->Subject)):
            $msg = "Nenhum assunto (->Subject) informado para a mensagem";
            throw new \Exception($msg,E_USER_ERROR);
        endif;
        
        if(empty($this->Body)){
            $msg = "Nenhuma mensagem (->msgHTML()) informada!";
            throw new \Exception($msg,E_USER_ERROR);
        }
        
        if(empty($this->to)):
            $msg = "Nenhum destinatário (->addAddress()) informado!";
            throw new \Exception($msg,E_USER_ERROR);
        endif;

        // Enviando o e-mail
        $return = parent::send();
        
        if ($return):
            return true;            
        else:
            throw new \Exception("Opss, falha ao enviar e-mail:",E_USER_ERROR);
        endif;
    }

}
