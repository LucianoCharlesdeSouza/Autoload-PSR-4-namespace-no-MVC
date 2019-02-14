<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Menu;

class HomeController extends Controller
{

    public function index()
    {

        $menu = new Menu;

        // $all = $menu->findAll();
        // dd($all);
        

        $this->loadTemplate('home', $this->getData());
    }

}