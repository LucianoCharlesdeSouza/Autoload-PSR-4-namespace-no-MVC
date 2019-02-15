<?php

namespace App\Http\Controllers\Painel;

use App\Core\Controller;

class HomeController extends Controller
{

    public function index()
    {    
        $this->loadTemplate('painel','home', $this->getData());
    }

}
