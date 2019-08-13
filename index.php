<?php

require_once("config.php");

if (isset($_GET["id"])) {
    $usuario = new Usuario();

    $usuario->loadById($_GET["id"]);

    echo $usuario;
} else {
    $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

    $usuarios = $sql->select("select * from tb_usuarios");

    echo json_encode($usuarios);
}

 ?>