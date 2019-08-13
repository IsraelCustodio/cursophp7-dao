<?php

require_once("config.php");

if (isset($_GET["id"])) {
    $usuario = new Usuario();

    $usuario->loadById($_GET["id"]);

    echo $usuario;
} else if (isset($_GET["login"]) && isset($_GET["senha"])) {
    $usuario = new Usuario();
    $usuario->login($_GET["login"], $_GET["senha"]);

    echo $usuario;
} else if (isset($_GET["login"])) {
    $usuarios = Usuario::search($_GET["login"]);

    echo json_encode($usuarios);
} else {
    $usuarios = Usuario::getList();

    echo json_encode($usuarios);
}

// echo json_encode($_GET);

 ?>