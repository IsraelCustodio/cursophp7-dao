<?php

require_once("config.php");

if (isset($_GET["id"])) {
    $usuario = new Usuario();

    $usuario->loadById($_GET["id"]);

    echo $usuario;
} else {
    $usuarios = Usuario::getList();

    echo json_encode($usuarios);
}

 ?>