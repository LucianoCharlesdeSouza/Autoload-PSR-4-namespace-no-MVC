<?php

use RTW\Classes\Encrypt;

/**
 * Função que recebe um inteiro e
 * retorna uma string json em base64
 */
if (!function_exists('cryptId')) {

    function cryptId($value)
    {
        return Encrypt::cryptId($value);
    }

}
/**
 * Método que recebe um json em base64 e
 * retorna um inteiro
 */
if (!function_exists('decryptId')) {

    function decryptId($value)
    {
        return Encrypt::decryptId($value);
    }

}
