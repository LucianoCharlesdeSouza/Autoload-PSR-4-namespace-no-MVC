<?php

namespace App\Http\Controllers;

use App\Core\Controller;

class DefaultController extends Controller
{

    public function notFound()
    {

      $this->loadView(null,'notFound',$this->getData());    

    }


}