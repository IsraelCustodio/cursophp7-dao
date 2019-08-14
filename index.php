<?php

require_once("config.php");

if (isset($_GET["acao"])) {
    $acao = $_GET["acao"];
} else {
    $acao = "";
}

switch ($acao) {
    case 'login':
        $usuario = new Usuario();
        $usuario->login($_GET["login"], $_GET["senha"]);

        echo $usuario;    
        break;

    case 'buscarid':
        if (isset($_GET["id"])) {
            $usuario = new Usuario();
            $usuario->loadById($_GET["id"]);

            echo $usuario;
        }        
        break;
    
    case 'buscarlogin':
        $usuarios = Usuario::search($_GET["login"]);

        echo json_encode($usuarios);
        break;

    case 'inserir':
        $usuario = new Usuario($_GET["novologin"], $_GET["senha"]);
        $usuario->insert();

        echo $usuario;
        break;

    case 'alterar':
        $usuario = new Usuario();
        $usuario->loadById($_GET["id"]);
        $usuario->update($_GET["login"], $_GET["senha"]);

        echo $usuario;
        break;

    case 'deletar':
        $usuario = new Usuario();
        $usuario->loadById($_GET["id"]);
        $usuario->delete();

        $usuarios = Usuario::getList();

        echo json_encode($usuarios);
        break;
    
    default:
        $usuarios = Usuario::getList();

        echo json_encode($usuarios);
        break;
}

// echo json_encode($_GET);

 ?>