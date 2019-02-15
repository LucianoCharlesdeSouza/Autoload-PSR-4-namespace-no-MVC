<?php

namespace RTW\Classes;

/**
 * Trait EmailTemplates
 * Possui metodos que retornam os html para envio de e-mail
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
trait EmailTemplates
{

    /**
     * Método que retorna o html para o envio de e-mail sobre a recuperação de senha
     * @param $name
     * @param $link
     * @return mixed
     */
    public function templateRecoverPassword($name, $link)
    {
        $mail_content = '<table width="550" style="font-family: "Trebuchet MS", sans-serif;">';
        $mail_content .= '<tr><td>';
        $mail_content .= '<font face="Trebuchet MS" size="3">';
        $mail_content .= '#mail_body#';
        $mail_content .= '</font>';
        $mail_content .= '<p style="font-size: 0.875em;">';
        $mail_content .= '<br><br>';

        $mail_content .= '</p>';
        $mail_content .= '</td></tr>';
        $mail_content .= '</table>';
        $mail_content .= '<style>';
        $mail_content .= 'body, img{';
        $mail_content .= 'max-width: 550px !important;';
        $mail_content .= 'height: auto !important;';
        $mail_content .= '}';
        $mail_content .= 'p{';
        $mail_content .= 'margin-botton: 15px 0 !important;';
        $mail_content .= '}';
        $mail_content .= '</style>';

        $body_mail = "<p style='font-size: 1.5em;'>";
        $body_mail .= "Olá, {$name}, recupere sua senha do Site " . mailer('mail_enviado_por') . "!";
        $body_mail .= "</p>";
        $body_mail .= "<p>Caso não tenha feito essa solicitação. ";
        $body_mail .= "Por favor ignore esse e-mail e nenhuma ação será tomada quanto aos dados de acesso!</p>";
        $body_mail .= "<p>Ou para criar uma nova senha de acesso ";
        $body_mail .= "<a title='Criar Nova Senha' href='" . $link . "'>CLIQUE AQUI!</a>!</p>";
        $body_mail .= "<p>Você será redirecionado para uma página onde poderá definir uma nova senha de acesso ao painel! ";
        $body_mail .= "Cuide bem dos seus dados.</p>";

        $msg = str_replace('#mail_body#', $body_mail, $mail_content);

        return $msg;
    }

    /**
     * Método que retorna o html para o envio de e-mail sobre o bloqueio do login duplo
     * @param $name
     * @param $timeBlocked
     * @return mixed
     */
    public function templateBlockedAccess($name, $timeBlocked)
    {
        $mail_content = '<table width="550" style="font-family: "Trebuchet MS", sans-serif;">';
        $mail_content .= '<tr><td>';
        $mail_content .= '<font face="Trebuchet MS" size="3">';
        $mail_content .= '#mail_body#';
        $mail_content .= '</font>';
        $mail_content .= '<p style="font-size: 0.875em;">';
        $mail_content .= '<br><br>';

        $mail_content .= '</p>';
        $mail_content .= '</td></tr>';
        $mail_content .= '</table>';
        $mail_content .= '<style>';
        $mail_content .= 'body, img{';
        $mail_content .= 'max-width: 550px !important;';
        $mail_content .= 'height: auto !important;';
        $mail_content .= '}';
        $mail_content .= 'p{';
        $mail_content .= 'margin-botton: 15px 0 !important;';
        $mail_content .= '}';
        $mail_content .= '</style>';

        $body_mail = "<p style='font-size: 1.5em;'>";
        $body_mail .= "Olá, {$name}, bloqueamos seu acesso ao " . mailer('mail_enviado_por') . "!";
        $body_mail .= "</p>";
        $body_mail .= "<p><strong>Motivo:</strong> ";
        $body_mail .= "Acesso com sessões diferentes usando seus dados!</p>";
        $body_mail .= "<p>Você ficará impedido de acessar novamente até:";
        $body_mail .= "<strong>" . date("d/m/Y H:i:s", strtotime($timeBlocked)) . "</strong></p>";
        $body_mail .= "<p>Cuide bem dos seus dados.</p>";

        $msg = str_replace('#mail_body#', $body_mail, $mail_content);

        return $msg;
    }

    /**
     * Método que retorna o html para o envio de e-mail sobre o primeiro acesso
     * @param $name
     * @param $link
     * @return mixed
     */
    public function templateFirstAccess($name, $link)
    {
        $mail_content = '<table width="550" style="font-family: "Trebuchet MS", sans-serif;">';
        $mail_content .= '<tr><td>';
        $mail_content .= '<font face="Trebuchet MS" size="3">';
        $mail_content .= '#mail_body#';
        $mail_content .= '</font>';
        $mail_content .= '<p style="font-size: 0.875em;">';
        $mail_content .= '<br><br>';

        $mail_content .= '</p>';
        $mail_content .= '</td></tr>';
        $mail_content .= '</table>';
        $mail_content .= '<style>';
        $mail_content .= 'body, img{';
        $mail_content .= 'max-width: 550px !important;';
        $mail_content .= 'height: auto !important;';
        $mail_content .= '}';
        $mail_content .= 'p{';
        $mail_content .= 'margin-botton: 15px 0 !important;';
        $mail_content .= '}';
        $mail_content .= '</style>';

        $body_mail = "<p style='font-size: 1.5em;'>";
        $body_mail .= "Ta quase, {$name}, agora basta você confirmar o recebimento deste e-mail, quer saber como? CLIQUE ABAIXO! ";
        $body_mail .= "</p>";
        $body_mail .= "<p>Isso é um procedimento padrão em nossos sistemas.</p>";
        $body_mail .= "<p>Então bora lá, fazermos seu primeiro acesso?";
        $body_mail .= "<a title='Confirmar e-mail' style='color:green;tex-decoration:none;' href='" . $link . "'> CONFIRME SEU E-MAIL!</a>!</p>";
        $body_mail .= "<p>Cuide bem dos seus dados.</p>";
        $body_mail .= "<p>Enviado por: " . mailer('mail_enviado_por') . "!</p>";

        $msg = str_replace('#mail_body#', $body_mail, $mail_content);

        return $msg;
    }

}
