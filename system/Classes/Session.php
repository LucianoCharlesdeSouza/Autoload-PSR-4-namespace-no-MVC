<?php

namespace RTW\Classes;

/**
 * Class Session

 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Session
{

    /**
     * Método que recebe um name e um valor para ser armazenado na sessão
     * @param $name
     * @param $val
     */
    public static function set($name, $val)
    {
        $_SESSION[$name] = $val;
    }

    /**
     * Método que recebe um nome de sessão para ser recuperado seu valor
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return (self::has($name)) ? $_SESSION[$name] : null;
    }

    /**
     * Método que retorna o array da sessão
     * @return mixed
     */
    public static function all()
    {
        return $_SESSION;
    }

    /**
     * Método que recebe um nome de sessão para verificar sua existência
     * @param $name
     * @return bool
     */
    public static function has($name)
    {
        return ( isset($_SESSION[$name]) ) ? true : false;
    }

    /**
     * Método que recebe um nome de sessão para desfazer ou destruir a mesma
     * @param string $name
     */
    public static function destroy($name = '')
    {
        if ($name != '')
            unset($_SESSION[$name]);
        else
            session_destroy();
    }

    /**
     * Método que regenera o id da sessão
     */
    public static function regenerate()
    {
        session_regenerate_id();
    }

    /**
     * Método que recebe um array de indices e valores para serem armazenados na sessão
     * @param array $data
     */
    public static function withInput(array $data)
    {
        foreach ($data as $name => $value) {
            self::set($name, $value);
        }
    }

    /**
     * Método que recebe um nome e valor para ser armazenados na sessão de nome fixo "SESSION_FLASH"
     * @param $name
     * @param $val
     */
    public static function setFlash($name, $val)
    {
        $_SESSION['SESSION_FLASH'][$name] = $val;
    }

    /**
     * Método que recebe um nome para recuperar um valor da sessão fixa "SESSION_FLASH"
     * @param $name
     * @return mixed
     */
    public static function getFlash($name)
    {
        $msg = null;

        if (self::hasFlash($name)) {
            $msg = $_SESSION['SESSION_FLASH'][$name];
            unset($_SESSION['SESSION_FLASH'][$name]);
        }

        return $msg;
    }

    /**
     * Método que recebe um nome de sessão para verificar sua existência
     * na sessão fixa "SESSION_FLASH"
     * @param $name
     * @return bool
     */
    public static function hasFlash($name)
    {
        return ( isset($_SESSION['SESSION_FLASH'][$name]) ) ? true : false;
    }

    /**
     * Método que gera o html para o retorno das msg de sessão
     * @return null|string
     */
    public static function boxFlashMsg()
    {
        if (static::hasFlash('httpCode')) {
            http_response_code(static::getFlash('httpCode'));
        }
        if (static::hasFlash('alert-type')) {
            $style = 'position: fixed; right: 24px; top: 60px; width: 360px; max-width: 80.5%; ';
            $style .= 'padding: 5px 10px 5px 10px; cursor: pointer; z-index: 9999;';
            $box = '<div style="';
            $box .= $style;
            $box .= '"  class="alert ';
            $box .= (static::hasFlash('alert-type')) ? static::getFlash('alert-type') : '';
            $box .= '  alert-dismissible fade show" role="alert" ">';
            $box .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>';
            $box .= '<h4><i class="';
            $box .= (static::hasFlash('alert_icon')) ? static::getFlash('alert_icon') : '';
            $box .= '" style=""></i><span> ';
            $box .= (static::hasFlash('alert_title')) ? static::getFlash('alert_title') : '';
            $box .= ' </span>';
            $box .= '</h4><div>';
            $box .= (static::hasFlash('alert_msg')) ? static::getFlash('alert_msg') : '';
            $box .= '</div></div>';

            return $box;
        }
        return null;
    }

    /**
     * Método que aplica as caracteristicas Danger ao html da box_flahs_msg
     * levando uma mensagem, titulo,e ou código http
     * @param $msg
     * @param string $title
     * @param null $httpCode
     */
    public static function flashDanger($msg, $title = 'Cuidado!', $httpCode = null)
    {
        static::setFlash('alert-type', 'alert-danger');
        static::setFlash('alert_icon', 'fa fa-ban');
        static::setFlash('alert_title', $title);
        static::setFlash('alert_msg', $msg);
        (isset($httpCode)) ? static::setFlash('httpCode', $httpCode) : '';
    }

    /**
     * Método que aplica as caracteristicas Warning ao html da box_flahs_msg
     * levando uma mensagem, titulo,e ou código http
     * @param $msg
     * @param string $title
     * @param null $httpCode
     */
    public static function flashWarning($msg, $title = 'Atenção!', $httpCode = null)
    {
        static::setFlash('alert-type', 'alert-warning');
        static::setFlash('alert_icon', 'fa fa-warning');
        static::setFlash('alert_title', $title);
        static::setFlash('alert_msg', $msg);
        (isset($httpCode)) ? static::setFlash('httpCode', $httpCode) : '';
    }

    /**
     * Método que aplica as caracteristicas INFO ao html da box_flahs_msg
     * levando uma mensagem, titulo,e ou código http
     * @param $msg
     * @param string $title
     * @param null $httpCode
     */
    public static function flashInfo($msg, $title = 'Informação!', $httpCode = null)
    {
        static::setFlash('alert-type', 'alert-info');
        static::setFlash('alert_icon', 'fa fa-info');
        static::setFlash('alert_title', $title);
        static::setFlash('alert_msg', $msg);
        (isset($httpCode)) ? static::setFlash('httpCode', $httpCode) : '';
    }

    /**
     * Método que aplica as caracteristicas SUCCESS ao html da box_flahs_msg
     * levando uma mensagem, titulo,e ou código http
     * @param $msg
     * @param string $title
     * @param null $httpCode
     */
    public static function flashSuccess($msg, $title = 'Sucesso!', $httpCode = null)
    {
        static::setFlash('alert-type', 'alert-success');
        static::setFlash('alert_icon', 'fa fa-check');
        static::setFlash('alert_title', $title);
        static::setFlash('alert_msg', $msg);
        (isset($httpCode)) ? static::setFlash('httpCode', $httpCode) : '';
    }

}
