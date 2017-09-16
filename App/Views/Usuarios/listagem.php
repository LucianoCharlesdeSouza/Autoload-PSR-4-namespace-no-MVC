<?php

if (!empty($lista_usuarios)) {
    foreach ($lista_usuarios as $user) {
        extract($user);
        echo "Nome: {$nome} <br />";
    }
}

