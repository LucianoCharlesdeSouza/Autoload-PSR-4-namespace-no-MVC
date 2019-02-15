<?php

namespace App\Http\Controllers\Site;

use App\Core\Controller;

class HomeController extends Controller
{

    public function index()
    {      
        $this->loadTemplate('site','home', $this->getData());
    }

    public function teste($param1,$param2)
    {
        var_dump($param1,$param2);
    }

}