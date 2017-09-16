<?php

namespace App\Controllers;

use App\Core\Controller,
    App\Models\User;

class usuariosController extends Controller {

    public function index() {
        $user = new User();
        $user->selectAll();

        $this->data['lista_usuarios'] = $user->getResult();

        $this->loadTemplate("Usuarios/listagem", $this->getData());
    }

}
