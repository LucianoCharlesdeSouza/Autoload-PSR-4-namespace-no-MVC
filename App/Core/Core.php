<?php

namespace App\Core;

class Core {

    private $Url = null;
    private $Controller = '';
    private $Action = '';
    private $Params = [];

    private function getUrl() {
        $url = '/';
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
        }
        $this->Url = $url;
    }

    private function getControllerActionParam() {

        if (!empty($this->Url) && $this->Url != '/') {
            $this->Url = explode('/', $this->Url);
            array_shift($this->Url);

            $this->Controller = $this->Url[0] . 'Controller';
            array_shift($this->Url);
            $this->getAction();
            $this->getParams();
        } else {
            $this->Controller = 'homeController';
            $this->Action = 'index';
        }
    }

    private function getAction() {
        if (isset($this->Url[0]) && !empty($this->Url[0])) {
            return $this->Action = $this->Url[0];
            array_shift($this->Url);
        }
        return $this->Action = 'index';
    }

    private function getParams() {
        if (count($this->Url) > 0) {
            foreach ($this->Url as $params):
                $this->Params = $params;
            endforeach;
        }
    }

    private function execute() {
        $controllerClassName = '\\App\\Controllers\\' . $this->Controller;
        if (!class_exists($controllerClassName)) {
            (new \App\Controllers\errorController())->index();
            return;
        }
        $controllerClass = new $controllerClassName();
        $controllerClass->{$this->Action}($this->Params);
    }

    public function run() {
        $this->getUrl();
        $this->getControllerActionParam();
        $this->execute();
    }

}
