<?php

namespace PWork\Mail;

/**
 *    FERNANDO PETRY
 *                                                   
 *     > 
 *     
 *     Classe: SmtpConfig
 *     @filesource SmtpConfig.class.php
 *     @package AZControl
 *     @subpackage 
 *     @category
 *     @version v1.0
 *     @since 21/03/2016 22:19:34
 *     @copyright (cc) 2015, Fernando Petry
 *     
 *     @author Fernando Petry <fernandopetry@live.com>                                                  
 */
class SmtpConfig {
    private $active;
    private $host;
    private $port;
    private $username;
    private $password;
    
    private $from;
    private $fromName;
    
    private $replyTo;
    private $replyToName;
    
    /**
     * Verifica se o SMTP está ativo ou não
     * @return booleam
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Nome do servidor SMTP
     * @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Numero da porta SMTP
     * @return integer
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * Usuario SMTP, normalmente um endereço de e-mail
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Senha de acesso ao SMTP
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * E-mail de origem da mensagem
     * @return string
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * Nome de quem esta enviando o email
     * @return string
     */
    public function getFromName() {
        return $this->fromName;
    }

    /**
     * Endereço de email para resposta
     * @return string
     */
    public function getReplyTo() {
        return $this->replyTo;
    }

    /**
     * Nome de quem irá receber as respostas de email
     * @return string
     */
    public function getReplyToName() {
        return $this->replyToName;
    }

    /**
     * Informa se o SMTP estara ativo ou não: TRUE e FALSE
     * @param booleam $active Status do SMTP: TRUE OU FALSE
     * @return \petry\mail\SmtpConfig
     */
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    /**
     * Informe o nome do servidor SMTP
     * @param string $host Nome do servidor
     * @return \petry\mail\SmtpConfig
     */
    public function setHost($host) {
        $this->host = $host;
        return $this;
    }

    /**
     * Informe a porta SMTP
     * @param integer $port Normalmente 587, 25
     * @return \petry\mail\SmtpConfig
     */
    public function setPort($port) {
        $this->port = $port;
        return $this;
    }

    /**
     * Informe o nome de usuario SMTP
     * @param string $username Nome do usuario
     * @return \petry\mail\SmtpConfig
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * Informe a senha de acesso para a conta SMTP
     * @param string $password Senha
     * @return \petry\mail\SmtpConfig
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Informe o e-mail e nome do usuario de origem das mensagens
     * @param string $from E-mail do usuario
     * @param string $name Nome do usuario
     * @return \petry\mail\SmtpConfig
     */
    public function setFrom($from,$name='') {
        $this->from = $from;
        $this->fromName = $name;
        return $this;
    }

    /**
     * Informe o e-mail e nome do usuario que receberá as respostas
     * @param string $replyTo E-mail do usuario
     * @param string $name Nome do usuario
     * @return \petry\mail\SmtpConfig
     */
    public function setReplyTo($replyTo,$name="") {
        $this->replyTo = $replyTo;
        $this->replyToName = $name;
        return $this;
    }


}

/*
 if (SMTP_ACTIVE) {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->Port = SMTP_PORT;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASSWORD;
        } else {
            $mail->isMail();
        }

        $mail->setFrom(SMTP_USER, SMTP_REPLY_TO_NAME);
        $mail->addReplyTo(SMTP_REPLY_TO, SMTP_REPLY_TO_NAME);
 */