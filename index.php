<?php

require_once("config.php");

$sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

$usuarios = $sql->select("select * from tb_usuarios");

echo json_encode($usuarios);

 ?>