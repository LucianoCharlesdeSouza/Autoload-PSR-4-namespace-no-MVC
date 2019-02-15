<?php

use RTW\Classes\Request;

/*
 * Função que retorna o valor do REQUEST (GET/POST) caso exista
 */
if (!function_exists('requestValue')) {

    function requestValue($name)
    {
        return (isset($_REQUEST[$name])) ? $_REQUEST[$name] : '';
    }

}

/*
 * Função que redireciona a página
 */

// if (!function_exists('redirect')) {

//     function redirect($to = null)
//     {
//         header("Location: " . base_url($to));
//         exit();
//     }

// }

/*
 * Função que redireciona a página após um determinado tempo
 */

if (!function_exists('redirectAfter')) {

    function redirectAfter($to = null, $time = 3)
    {
        header("Refresh: " . $time . ";url=" . base_url($to));
        exit();
    }

}


/*
 * Função que recupera os valores do request
 */

// if (!function_exists('request')) {

//     function request($name)
//     {
//         $value = '';
//         if (sessionHas($name)) {
//             $value = getSession($name);
//             sessionDestroy($name);
//         }

//         return $value;
//     }

// }
