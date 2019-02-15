<?php

use RTW\Classes\Encrypt;
use RTW\Classes\Session;
/*
 * Função que seta o Token do App na Sessão
 */

if (!function_exists('setToken')) {

    function setToken()
    {
        $token = Encrypt::crypt(uniqid(date('YmdHis')));
        Session::set('_token', $token);
    }

}

/*
 * Função que gera o input hidden para o Token do App
 */

if (!function_exists('csrf')) {

    function csrf()
    {
        setToken();
        return '<input type="hidden" class="_token" name="_token" value="' . getSession('_token') . '">';
    }

}
