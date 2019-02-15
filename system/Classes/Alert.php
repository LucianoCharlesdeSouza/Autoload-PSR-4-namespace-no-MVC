<?php

namespace RTW\Classes;
/**
 * Class Alert
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Alert
{

    public static function AjaxSuccess($descryption, $title = "")
    {
        if ($title != ""):
            return ["alert alert-success", "fa fa-check", $title, $descryption];
        endif;

        return ["alert alert-success", "fa fa-check", " Sucesso!", $descryption];
    }

    public static function AjaxInfo($descryption, $title = "")
    {
        if ($title != ""):
            return ["alert alert-info", "fa fa-info", $title, $descryption];
        endif;
        return ["alert alert-info", "fa fa-info", " Informação!", $descryption];
    }

    public static function AjaxWarning($descryption, $title = "")
    {
        if ($title != ""):
            return ["alert alert-warning", "fa fa-warning", $title, $descryption];
        endif;
        return ["alert alert-warning", "fa fa-warning", " Atenção!", $descryption];
    }

    public static function AjaxDanger($descryption, $title = "")
    {
        if ($title != ""):
            return ["alert alert-danger", "fa fa-ban", $title, $descryption];
        endif;
        return ["alert alert-danger", "fa fa-ban", " Cuidado!", $descryption];
    }

    public static function AjaxRedirect($toWhere, $time = null)
    {
        if ($time != null):
            return [$toWhere, $time];
        endif;
        return [$toWhere, 3200];
    }

}
