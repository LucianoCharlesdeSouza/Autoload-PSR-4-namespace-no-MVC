<?php

use RTW\Classes\Cookie;

/**
 * Função que recupera um cookie
 */

if (!function_exists('getCookie')) {

    function getCookie($name, $default = null)
    {
        return (Cookie::has($name)) ? Cookie::get($name, $default = null) : null;
    }

}

