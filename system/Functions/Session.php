<?php

use RTW\Classes\Session;

/*
 * Função que retorna a box de mensagens da Sessão
 */

if (!function_exists('boxFlash')) {

    function boxFlash()
    {
        return Session::boxFlashMsg();
    }

}


/*
 * Função que seta um nome e um valor para a Sessão
 */

if (!function_exists('setSessionFlash')) {

    function setSessionFlash($name, $val)
    {
        Session::setFlash($name, $val);
    }

}

/*
 * Função que retorna um valor de um nome de Sessão
 */

if (!function_exists('getSessionFlash')) {

    function getSessionFlash($name)
    {
        return (hasSessionFlash($name)) ? Session::getFlash($name) : null;
    }

}

/*
 * Função que verifica a existência de um nome de Sessão
 */

if (!function_exists('hasSessionFlash')) {

    function hasSessionFlash($name)
    {
        return Session::hasFlash($name);
    }

}

/*
 * Função que cria vários nomes de Sessão com seus devidos valores
 */

if (!function_exists('sessionWithInput')) {

    function sessionWithInput(array $data)
    {
        foreach ($data as $name => $value) {
            setSessionFlash($name, $value);
        }
    }

}
/*
 * Função que cria uma Sessão
 */

if (!function_exists('setSession')) {

    function setSession($name, $valeu)
    {
        return Session::set($name, $valeu);
    }

}

/*
 * Função que recupera uma Sessão
 */

if (!function_exists('getSession')) {

    function getSession($name)
    {
        return Session::get($name);
    }

}

/*
 * Função que verifica um nome de sessão
 */

if (!function_exists('sessionHas')) {

    function sessionHas($name)
    {
        return Session::has($name);
    }

}

/*
 * Função que destroi toda uma Sessão
 */

if (!function_exists('sessionDestroy')) {

    function sessionDestroy($name = '')
    {

        if (sessionHas($name)) {
            Session::destroy($name);
        }
    }

}
