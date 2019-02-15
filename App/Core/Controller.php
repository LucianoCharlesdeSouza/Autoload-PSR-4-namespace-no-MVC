<?php

namespace App\Core;

class Controller
{

    protected $data = [];

    public function __construct()
    {

    }

    protected function getData()
    {
        return $this->data;
    }

    public function __call($name, $arguments)
    {
        $this->loadTemplate('error_404');
    }

    public function loadView($viewFolder, $viewName, $viewData = array())
    {
        extract($viewData);
        include_once '../app/Views/' . $viewFolder . "/" . $viewName . '.php';
    }

    public function loadTemplate($viewFolder, $viewName, $viewData = array())
    {
        include "../app/Views/{$viewFolder}/template.php";
    }

    public function loadViewInTemplate($viewFolder,$viewName, $viewData)
    {
        extract($viewData);
        include '../app/Views/' . $viewFolder . "/" . $viewName . '.php';
    }

}
