<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

define("FOLDER_APP",'');

if(FOLDER_APP == ''){
    require '../vendor/autoload.php';
    
    foreach (glob('../system/Functions/*.php') as $file) {
      include_once $file;
    }
    
    require '../routes/web.php';

}else{
    
    require '../'.FOLDER_APP.'/vendor/autoload.php';
    
    foreach (glob('../'.FOLDER_APP.'/system/Functions/*.php') as $file) {
      include_once $file;
    }
    
    require '../'.FOLDER_APP.'/routes/web.php';   
}


\App\Route::start();
