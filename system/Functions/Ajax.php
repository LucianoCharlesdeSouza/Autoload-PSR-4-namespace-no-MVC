<?php

use RTW\Classes\Session;
/*
 * Função que retorna a box de mensagens do Ajax
 */

if (!function_exists('boxAjax')) {

    function boxAjax()
    {
        $box = '<div style="position: fixed;right: 10px;top: 50px;';
        $box .= 'width: 360px;max-width: 80%;padding: 10px 20px 10px 20px;';
        $box .= 'cursor: pointer;z-index: 9999;margin-bottom: 20px;" class="alerta ">';
        $box .= '<span aria-hidden="true" style="float:right;" class="btnAjaxClose"></span>';
        $box .= ' <h4><i class = "icon icones "></i><span class = "titulo"></span></h4>';
        $box .= ' <div class = "result"></div>';
        $box .= ' </div>';

        return $box;
    }

}

/*
 * Função que retorna os atributos necessário ao motor Ajax
 */
if (!function_exists('ajaxForm')) {

    function ajaxForm($controller, $class = null)
    {
        Session::set('ajaxForm', true);
        return 'class="ajaxForm ' . $class . '" data-controller="' . $controller . '"';
    }

}

/*
 * Função que retorna botão usado na requisição Ajax
 */
if (!function_exists('btnAjaxForm')) {

    function btnAjaxForm($value, $class = null)
    {
        return '<button class="' . $class . '"><i class="btnAjaxForm fa "></i> ' . $value . '</button>';
    }

}

/*
 * Função que retorna botão usado para deletar na requisição Ajax
 */
if (!function_exists('btnDeleteAjax')) {

    function btnDeleteAjax($controller, $id, $value = 'Excluir', $class = null)
    {
        return '<button class="ajaxDelete ' . $class . '" data-controller="' . $controller . '" id="' . $id . '">' . $value . '</button>';
    }

}
