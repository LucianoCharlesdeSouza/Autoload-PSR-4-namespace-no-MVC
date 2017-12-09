<?php

namespace App\Controllers;

use App\Core\Controller,
    App\Models\User;

class usuariosController extends Controller {

    private $User;

    public function __construct() {
        parent::__construct();
        $this->User = new User();
    }

    public function index() {

        if ($this->User->selectAll()) {

            $this->data['lista_usuarios'] = $this->User->getResult();
        }

        $this->loadTemplate("Usuarios/listagem", $this->getData());
    }

}
