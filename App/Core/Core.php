<?php

namespace App\Core;

class Core {

    public function run() {
        $url = '/';
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
        }

        $params = array();
        if (!empty($url) && $url != '/') {
            $url = explode('/', $url);
            array_shift($url);

            $currentController = $url[0] . 'Controller';
            array_shift($url);

            if (isset($url[0]) && !empty($url[0])) {
                $currentAction = $url[0];
                array_shift($url);
            } else {
                $currentAction = 'index';
            }

            if (count($url) > 0) {
                $params = $url;
            }
        } else {
            $currentController = 'homeController';
            $currentAction = 'index';
        }

//        if (!file_exists('controllers/' . $currentController . '.php') || !method_exists($currentController, $currentAction)):
//            $c = new errorController();
//            $currentAction = 'index';
//        else:
//            $c = new $currentController();
//        endif;
//
//        call_user_func_array(array($c, $currentAction), $params);

        $controllerClassName = '\\App\\Controllers\\' . $currentController;
        if (!class_exists($controllerClassName)) {
            (new \App\Controllers\errorController())->index();
            return;
        }

        $controllerClass = new $controllerClassName();
        $controllerClass->{$currentAction}($params);
    }

}
