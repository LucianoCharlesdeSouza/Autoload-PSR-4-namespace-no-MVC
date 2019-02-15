<?php

namespace RTW\Classes;

/**
 * Classe  Encrypt
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Encrypt
{

    /**
     * Método que recebe uma valor e/ou uma chave para criptografia e
     * retorna uma string criptografada
     * @param $val
     * @param string $key
     * @return string
     */
    public static function crypt($val, $key = '')
    {
        $start = substr($val, 0, 2);
        $middle = substr($val, 2, -2);
        $end = substr($val, -2);

        $encrypt = base64_encode($middle . $key . $start . app("app_key") . $end);

        return $encrypt;
    }

    /**
     * Método que recebe uma valor criptografado e/ou uma chave para descriptografia e
     * retorna uma string descriptografada
     * @param $val
     * @param string $key
     * @return bool|mixed|string
     */
    public static function decrypt($val, $key = '')
    {
        $decrypt = base64_decode($val);

        $decrypt = str_replace(app("app_key"), '', str_replace($key, '', $decrypt));

        $start = substr($decrypt, -4, 2);
        $middle = substr($decrypt, 0, -4);
        $end = substr($decrypt, -2);

        $decrypt = $start . $middle . $end;

        return $decrypt;
    }

    /**
     * Método que recebe uma valor e
     * retorna uma uma hash
     * @param $val
     * @return string
     */
    public static function hash($val)
    {
        $encrypt = self::crypt(crypt(hash('sha512', $val), md5(app('app_key'))));

        return $encrypt;
    }

    /**
     * Método que recebe um valor e
     * retorna um hash BCRYPT
     * @param $value
     * @return bool|string
     */
    public static function createPassword($value)
    {
        return password_hash(app('app_key') . $value, PASSWORD_BCRYPT);
    }

    /**
     * Método que recebe um valor e compara com um hash BCRYPT e
     * retorna true ou false
     * @param $value
     * @param $hash
     * @return bool
     */
    public static function verifyPassword($value, $hash)
    {
        return password_verify(app('app_key') . $value, $hash);
    }

    /**
     * Método que recebe um inteiro e
     * retorna uma string json em base64
     *
     * @param int $value
     * @return string
     */
    public static function cryptId($value)
    {
        $key = [
            'id' => mt_rand(0, 9),
            'id_' => mt_rand(0, 9999999),
            'key' => $value,
            'idpk' => mt_rand(0, 99),
            'ch' => mt_rand(0, 999)
        ];
        return base64_encode(json_encode($key));
    }

    /**
     * Método que recebe um json em base64 e
     * retorna um inteiro
     * @param $value
     * @return mixed
     */
    public static function decryptId($value)
    {
        $key_ = base64_decode($value);
        $json = json_decode($key_);
        return $json->key;
    }

}
