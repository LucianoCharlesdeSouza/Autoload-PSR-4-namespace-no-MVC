<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Menu;

class HomeController extends Controller
{

    public function index()
    {

        $menu = new Menu;
        $bindValue = ['id' => 2];
        $paginate = $menu->paginate();
        dd($paginate);

        $this->loadTemplate('home', $this->getData());
    }

}