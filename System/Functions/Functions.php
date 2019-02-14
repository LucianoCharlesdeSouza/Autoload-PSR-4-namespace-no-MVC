<?php

/*
 * Função que retorna o array de configurações do arquivo database.php
 * da pasta config, conforme o valor do indice environment do arquivo
 * environment.php da mesma pasta
 */
if (!function_exists('database')) {

    function database($key = null)
    {

        $app = include dirname(__DIR__, 2) . '/config/database.php';

        if ($app['environment'] === 'development') {

            return (isset($key)) ? $app['connections']['development'][$key] : $app['connections']['development'];
        }

        return (isset($key)) ? $app['connections']['production'][$key] : $app['connections']['production'];
    }

}

/*
 * Função que retorna o array de configurações do arquivo app.php
 * da pasta config
 */
if (!function_exists('app')) {

    function app($key = null)
    {

        $app = include dirname(__DIR__, 2) . '/config/app.php';

        return (isset($key)) ? $app[$key] : $app;
    }

}
/*
 * Função que retorna o array de configurações do arquivo environment.php
 * da pasta config
 */
if (!function_exists('environment')) {

    function environment($key = null)
    {

        $app = include dirname(__DIR__, 2) . '/config/environment.php';

        return (isset($key)) ? $app[$key] : $app;
    }

}
/*
 * Função que retorna o array de configurações do arquivo mail.php
 * da pasta config
 */
if (!function_exists('mailer')) {

    function mailer($key = null)
    {

        $app = include dirname(__DIR__, 2) . '/config/mail.php';

        return (isset($key)) ? $app[$key] : $app;
    }

}

/*
 * Função que retorna a URL do projeto
 */
if (!function_exists('base_url')) {

    function base_url($path = null)
    {

        $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

        if ($path == null) {
            return $url;
        }

        return $url . $path;
    }

}

/*
 * Função que retorna uma URL
 */
if (!function_exists('back_url')) {

    function back_url($path = null)
    {

        if ($path == null) {
            return str_replace(basename(dirname($_SERVER['SCRIPT_FILENAME'])), '', base_url());
        }

        return str_replace(basename(dirname($_SERVER['SCRIPT_FILENAME'])), '', base_url($path));
    }

}

/*
 * Função que aplica o htmlentities() para inibir a execução de scripts
 * maliciosos nas views
 */
if (!function_exists('html')) {

    function html($data)
    {
        $data = str_replace('<?php', '', str_replace('?>', '', str_replace('<?=', '', $data)));
        return htmlentities(stripTags($data), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

}

/*
 * Função que retorna o do_dump formatado
 */
if (!function_exists('dd')) {

    function dd(&$var, $die = true, $info = false)
    {
        $scope = false;
        $prefix = 'unique';
        $suffix = 'value';

        $vals = $GLOBALS;
        if ($scope) {
            $vals = $scope;
        }

        $old = $var;
        $var = $new = $prefix . rand() . $suffix;
        $vname = false;
        foreach ($vals as $key => $val)
            if ($val === $new)
                $vname = $key;
        $var = $old;

        echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: black; color: white; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 12px; line-height: 15px;'>";
        if ($info != false)
            echo "<strong style='color:#a2e80b;'>$info:</strong><br />";
        do_dump($var, $vname);
        echo "</pre>";
        if ($die != false)
            die();
    }

}

/*
 * Função que retorna o debug formatado
 */
if (!file_exists('do_dump')) {

    function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
    {
        $do_dump_indent = "<span style='color:#eeeeee;'></span> &nbsp;&nbsp; ";
        $reference = $reference . $var_name;
        $keyvar = 'the_do_dump_recursion_protection_scheme';
        $keyname = 'referenced_object_name';

        if (is_array($var) && isset($var[$keyvar])) {
            $real_var = &$var[$keyvar];
            $real_name = &$var[$keyname];
            $type = strtolower(gettype($real_var));
            echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br />";
        } else {
            $var = array($keyvar => $var, $keyname => $reference);
            $avar = &$var[$keyvar];

            $type = strtolower(gettype($avar));

            switch ($type) {
                case 'string':
                    $type_color = "<span style='color:yellow'>";
                    break;
                case 'integer':
                    $type_color = "<span style='color:#2A2AFF'>";
                    break;
                case 'double':
                    $type_color = "<span style='color:#FFB530'>";
                    $type = "float";
                    break;
                case 'boolean':
                    $type_color = "<span style='color:#9B369B'>";
                    break;
                case 'null':
                    $type_color = "<span style='color:red'>";
                    break;
            }

            if (is_array($avar)) {
                $count = count($avar);
                echo "$indent" . ($var_name ? "$var_name => " : "") . "<span style='color:#c3c3c3'>$type ($count)</span><br />$indent(<br />";
                $keys = array_keys($avar);
                foreach ($keys as $name) {
                    $value = &$avar[$name];
                    $n = "<span style='color:#7eb6c9'>{$name}</span>";
                    do_dump($value, "[$n]", $indent . $do_dump_indent, $reference);
                }
                echo "$indent)<br />";
            } elseif (is_object($avar)) {
                echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br />$indent(<br />";
                foreach ($avar as $name => $value) {
                    $n = "<span style='color:#7eb6c9'>{$name}</span>";
                    do_dump($value, "$n", $indent . $do_dump_indent, $reference);
                }
                echo "$indent)<br />";
            } elseif (is_int($avar))
                echo "$indent$var_name : <span style='color:#2A2AFF'>$type(" . strlen($avar) . ")</span> $type_color$avar</span><br />";
            elseif (is_string($avar))
                echo "$indent$var_name : <span style='color:green'>$type(" . strlen($avar) . ")</span> $type_color\"$avar\"</span><br />";
            elseif (is_float($avar))
                echo "$indent$var_name : <span style='color:#FFB530'>$type(" . strlen($avar) . ")</span> $type_color$avar</span><br />";
            elseif (is_bool($avar))
                echo "$indent$var_name : <span style='color:#9B369B'>$type(" . strlen($avar) . ")</span> $type_color" . ($avar == 1 ? "true" : "false") . "</span><br />";
            elseif (is_null($avar))
                echo "$indent$var_name : <span style='color:red'>$type(" . strlen($avar) . ")</span> {$type_color}NULL</span><br />";
            else
                echo "$indent$var_name : <span style='color:#a2a2a2'>$type(" . strlen($avar) . ")</span> $avar<br />";

            $var = $var[$keyvar];
        }
    }

}

/**
 * Função que higieniza tanto entrada quanto saísa dos dados
 * @param $text
 * @param string $tags
 * @param bool $invert
 * @return mixed
 */
if (!function_exists('stripTags')) {

    function stripTags($text, $tags = '', $invert = FALSE)
    {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if (is_array($tags) AND count($tags) > 0) {
            if ($invert == FALSE) {
                return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            } else {
                return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
            }
        } elseif ($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

}
