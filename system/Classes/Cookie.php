<?php

namespace RTW\Classes;

/**
 * Class Cookie
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Cookie
{

    /**
     * Método que recebe um nome e valor de um cookie,
     * podendo receber um valor com a qtd de dias a ficar ativo
     * @param $name
     * @param $value
     * @param int $days (null)
     * @return bool
     */
    public static function set($name, $value, $days = null)
    {
        $expire = is_null($days) ? 0 : (time() + ($days * 24 * 3600));
        return setcookie($name, $value, (int) $expire);
    }

    /**
     * Método que recebe um nome para recuperar o valor do cookie
     * @param $name
     * @param mixed $default (null)
     * @return mixed
     * @SuppressWarnings("superglobals")
     */
    public static function get($name, $default = null)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    /**
     * Método que recebe um nome de cookie e o desfaz ou o destroi
     * @param $name
     * @return bool
     * @SuppressWarnings("superglobals")
     */
    public static function destroy($name)
    {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            return self::set($name, null, time() - (24 * 3600));
        }
        return false;
    }

    /**
     * Método que recebe um nome de cookie e verifica sua existência
     * @param $name
     * @return bool
     */
    public static function has($name)
    {
        if (isset($_COOKIE[$name])) {
            return true;
        }
        return false;
    }

}
