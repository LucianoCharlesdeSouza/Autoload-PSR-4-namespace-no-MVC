<?php

require 'environment.php';

global $config;
$config = array();

if (ENVIRONMENT == 'development') {
    define("BASE", "http://localhost/mvc_composer_namespace/");
    define("BASEADMIN", "http://localhost/mvc_composer_namespace/App/admin/");
    $config['dbname'] = '';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = '';
} else {
    define("BASE", "https://seudominio_real/");
    define("BASEADMIN", "https://seudominio_real/admin/");
    $config['dbname'] = 'grupo++';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'user';
    $config['dbpass'] = '';
}

