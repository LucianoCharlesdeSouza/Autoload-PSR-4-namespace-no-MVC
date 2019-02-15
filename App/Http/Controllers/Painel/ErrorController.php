<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller {

    public function index() {

        $this->loadTemplate('error_404', $this->getData());
        
    }

}
