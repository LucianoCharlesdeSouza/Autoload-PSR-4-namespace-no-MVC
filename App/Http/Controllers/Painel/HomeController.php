<?php

namespace App\Http\Controllers\Painel;

use App\Core\Controller;

class HomeController extends Controller
{

    public function index()
    {      
        $this->loadTemplate('painel','home', $this->getData());
    }

    public function teste($param1,$param2)
    {
        $this->data['parametros'] = [$param1,$param2];

        $this->loadTemplate('painel','teste', $this->getData());
    }

}