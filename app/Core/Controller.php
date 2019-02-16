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
        if(FOLDER_APP == ''){
            include_once '../app/Views/' . $viewFolder . "/" . $viewName . '.php';
        }else{
             include_once '../'.FOLDER_APP.'/app/Views/' . $viewFolder . '/' . $viewName . '.php';
        }
    }

    public function loadTemplate($viewFolder, $viewName, $viewData = array())
    {
        if(FOLDER_APP == ''){
            include "../app/Views/{$viewFolder}/template.php";
        }else{
            include "../".FOLDER_APP."/app/Views/{$viewFolder}/template.php";
        }
    }

    public function loadViewInTemplate($viewFolder,$viewName, $viewData)
    {
        extract($viewData);
        if(FOLDER_APP == ''){
             include '../app/Views/' . $viewFolder . "/" . $viewName . '.php';
        }else{
            include '../'.FOLDER_APP.'/app/Views/' . $viewFolder . '/' . $viewName . '.php';
        }
    }

}
