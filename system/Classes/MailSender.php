<?php

namespace RTW\Classes;

/**
 * Class  Mail_Sender

 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class MailSender
{

    private $de;
    private $para = null;
    private $emailRecusado;
    private $tipo = "text/plain";
    private $assunto;
    private $mensagem;
    private $cabecalhos;
    private $prioridade = 3;
    private $responderPara = null;
    private $msgError;

    /**
     * Mail_Sender constructor.
     */
    public function __construct()
    {
        $this->getTipoEmail();
        $this->getPrioridade();
        $this->getResponderPara();
    }

    /**
     * @return string
     */
    private function getTipoEmail()
    {
        return $this->tipo;
    }

    /**
     * Método que aplica o tipo de envio
     */
    public function comoHtml()
    {
        $this->tipo = "text/html";
    }

    /**
     * @param $de
     */
    public function setDe($de)
    {
        if (Helpers::isMail($de)) {
            $this->de = $de;
        } else {
            $this->msgError = "E-mail passado não é válido!";
        }
    }

    /**
     * @return bool
     */
    private function getDe()
    {
        if ($this->de) {
            return $this->de;
        } else {
            return false;
        }
    }

    /**
     * @param $para
     */
    public function setPara($para)
    {
        if (is_array($para)) {
            if (count($para) > 1) {
                foreach ($para as $email) {
                    if (Helpers::isMail($email)) {
                        $this->para = $this->para . $email . ",";
                    } else {
                        $this->msgError = "<br/>" . $this->emailRecusado . $email . "<br/>";
                    }
                }
            } else {
                $this->para = $para[0];
            }
        } else {
            $this->msgError = "O método setPara só aceita <strong>array</strong>";
        }
    }

    private function getPara()
    {
        if ($this->para != null) {
            return rtrim($this->para, ',');
        } else {
            return $this->msgError;
        }
    }

    public function setAssunto($assunto)
    {
        if (is_string($assunto)) {
            $this->assunto = trim($assunto);
        } else {
            $this->msgError = "Você de passar uma <strong>STRING</strong> como parâmetro!";
        }
    }

    private function getAssunto()
    {
        return $this->assunto;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    private function getMensagem()
    {
        return $this->mensagem;
    }

    public function setPrioridade($prioridade)
    {
        if (is_int($prioridade)) {
            $this->prioridade = $prioridade;
        } else {
            $this->msgError = "Você deve passar um valor <strong>INTEIRO</strong> como parâmetro!";
        }
    }

    private function getPrioridade()
    {
        return $this->prioridade;
    }

    public function setResponderPara($para)
    {
        if (is_array($para)) {
            if (count($para) > 1) {
                foreach ($para as $email) {
                    if (Helpers::isMail($email)) {
                        $this->responderPara = $this->responderPara . $email . ",";
                    } else {
                        $this->msgError = "<br/>" . $this->emailRecusado . $email . "<br/>";
                    }
                }
            } else {
                $this->responderPara = $para[0];
            }
        } else {
            $this->msgError = "O método setResponderPara só aceita <strong>array</strong>";
        }
    }

    private function getResponderPara()
    {
        if ($this->responderPara != null) {
            return rtrim($this->responderPara, ',');
        } else {
            return $this->getDe();
        }
    }

    private function getCabecalhos()
    {
        return $this->cabecalhos = "From:" . $this->getDe() . "\r\n" .
                "Reply-To:" . $this->getResponderPara() . "\r\n" .
                "X-Mailer:PHP/" . phpversion() . "\r\n" .
                "Erros-To:" . $this->getDe() . "\r\n" .
                "Return-Path:" . $this->getDe() . "\r\n" .
                "Content-Type:" . $this->getTipoEmail() . "; charset='utf-8'" . "\r\n" .
                "Date:" . date("r(T)") . "\r\n" .
                "X-Priority:" . $this->getPrioridade() . "\r\n" .
                "MIME-Version:1.1";
    }

    public function getError()
    {
        return $this->msgError;
    }

    public function Enviar()
    {
        if (!$this->getDe()) {
            return false;
        } else {
            if (mail($this->getPara(), $this->getAssunto(), $this->getMensagem(), $this->getCabecalhos())) {
                return true;
            } else {
                return false;
            }
        }
    }

}
