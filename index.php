<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';
require 'config.php';

use App\Core\Core;

$core = new App\Core\Core();
$core->run();

