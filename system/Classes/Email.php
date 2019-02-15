<?php

namespace RTW\Classes;

use RTW\Library\Mailer\PHPMailerException;
use RTW\Library\Mailer\SMTP;
use RTW\Library\Mailer\PHPMailer;
/**
 * Class Email
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Email
{

    use EmailTemplates;

    /** @var PHPMailer */
    public $mail;

    /** EMAIL DATA */
    private $data;

    /** CORPO DO E-MAIL */
    private $assunto;
    private $mensagem;

    /** REMETENTE */
    private $remetenteNome;
    private $remetenteEmail;

    /** DESTINO */
    private $destinoNome;
    private $destinoEmail;

    /** ERROR */
    private $error;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->Host = mailer('mail_host');
        $this->mail->Port = mailer('mail_port');
        $this->mail->Username = mailer('mail_username');
        $this->mail->Password = mailer('mail_password');
        $this->mail->SMTPAuth = mailer('mail_smtpauth');

        if (!empty(mailer('mail_smtpsecure'))):
            $this->mail->SMTPSecure = mailer('mail_smtpsecure');
        endif;
    }

    /**
     * <b>Enviar E-mail SMTP:</b> Envelope os dados do e-mail em um array atribuitivo para povoar o método.
     * Com isso execute este para ter toda a validação de envio do e-mail feita automaticamente.
     *
     * <b>REQUER DADOS ESPECÍFICOS:</b> Para enviar o e-mail você deve montar um array associativo com os
     * seguintes índices corretamente povoados:<br><br>
     * <i>
     * &raquo; Assunto<br>
     * &raquo; Mensagem<br>
     * &raquo; RemetenteNome<br>
     * &raquo; RemetenteEmail<br>
     * &raquo; DestinoNome<br>
     * &raquo; DestinoEmail
     * </i>
     */
    private function send_(array $data)
    {
        $this->data = $data;
        $this->clear();

        $data['RemetenteNome'] = ($data['RemetenteNome'] != 'null' ? $data['RemetenteNome'] : null);
        $this->setMail();
        $this->config();
    }

    /**
     * <b>Montar e Enviar:</b> Execute este método para facilitar o envio.
     * Informando os parâmetros solicitados para montar os dados!
     */
    public function createEmail($assunto, $mensagem, $remetenteNome, $remetenteEmail, $destinoNome = null, $destinoEmail = null)
    {
        $data['Assunto'] = $assunto;
        $data['Mensagem'] = $mensagem;
        $data['RemetenteNome'] = $remetenteNome;
        $data['RemetenteEmail'] = $remetenteEmail;
        $data['DestinoNome'] = ($destinoNome != null) ? $destinoNome : mailer('mail_nomedestinatario');
        $data['DestinoEmail'] = ($destinoEmail != null) ? $destinoEmail : mailer('mail_emaildestinatario');
        $this->send_($data);
    }

    /**
     * Faz o envio do E-mail
     * @return bool
     */
    public function sendMail()
    {
        try {
            if ($this->mail->Send()) {
                $this->mail->clearAddresses();
                return true;
            }
            $this->error = $this->mail->ErrorInfo;
        } catch (Exception $e) {
            die($this->mail->ErrorInfo);
        }
    }

    /**
     * Faz o anexo ao E-mail
     * @param $File
     */
    public function addFile($File)
    {
        $this->mail->addAttachment($File);
    }

    /**
     * Retorna o erro caso não envie o email
     * @return msg
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Higieniza os dados para o envio
     */
    private function clear()
    {
        array_map('strip_tags', $this->data);
        array_map('trim', $this->data);
    }

    /**
     * Recupera e separa os atributos pelo Array Data.
     */
    private function setMail()
    {
        $this->assunto = $this->data['Assunto'];
        $this->mensagem = $this->data['Mensagem'];
        $this->remetenteNome = $this->data['RemetenteNome'];
        $this->remetenteEmail = $this->data['RemetenteEmail'];
        $this->destinoNome = $this->data['DestinoNome'];
        $this->destinoEmail = $this->data['DestinoEmail'];
        $this->data = null;
    }

    /**
     * Configura o PHPMailer e valida o e-mail!
     */
    private function config()
    {
        //SMTP AUTH
        $this->mail->SMTPOptions = mailer('mail_smtpoptions');
        $this->mail->CharSet = mailer('mail_charset');
        $this->mail->setLanguage('pt');
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = mailer('mail_smtpdebug');
        $this->mail->IsHTML(true);


        //REMETENTE E RETORNO
        $this->mail->From = mailer('mail_username'); /* email de quem envia */
        $this->mail->FromName = mailer('mail_enviado_por'); /* Nome do remetente de e-mail */
        $this->mail->AddReplyTo($this->remetenteEmail, $this->remetenteNome);

        //ASSUNTO, MENSAGEM E DESTINO
        $this->mail->Subject = $this->assunto;
        $this->mail->msgHTML($this->mensagem);
        $this->mail->AddAddress($this->destinoEmail, $this->destinoNome);
    }

}
