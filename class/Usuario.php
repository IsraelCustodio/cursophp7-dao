<?php

class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getDeslogin() {
        return $this->deslogin;
    }

    public function setDeslogin($deslogin) {
        $this->deslogin = $deslogin;
    }

    public function getDessenha() {
        return $this->dessenha;
    }

    public function setDessenha($dessenha) {
        $this->dessenha = $dessenha;
    }

    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    public function setDtcadastro($dtcadastro) {
        $this->dtcadastro = $dtcadastro;
    }

    public function loadById($id) {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        $results = $sql->select("select * from tb_usuarios where idusuario = :id;", array(
            ":id" => $id
        ));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdusuario($row["idusuario"]);
            $this->setDeslogin($row["deslogin"]);
            $this->setDessenha($row["dessenha"]);
            $this->setDtcadastro(new DateTime($row["dtcadastro"]));
        }
    }

    public static function getList() {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        return $sql->select("select * from tb_usuarios order by idusuario;");
    }

    public static function search($login) {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        return $sql->select("select * from tb_usuarios where deslogin like :search order by deslogin;", array(
            ":search" => "%" . $login . "%"
        ));
    }

    public function login($login, $senha) {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        $results = $sql->select("select * from tb_usuarios where deslogin = :login and dessenha = :senha;", array(
            ":login" => $login,
            ":senha" => $senha
        ));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdusuario($row["idusuario"]);
            $this->setDeslogin($row["deslogin"]);
            $this->setDessenha($row["dessenha"]);
            $this->setDtcadastro(new DateTime($row["dtcadastro"]));
        } else {
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function __toString() {
        return json_encode(array(
            "idusuario" => $this->getIdusuario(),
            "deslogin" => $this->getDeslogin(),
            "dessenha" => $this->getDessenha(),
            "dtcadastro" => $this->getDtcadastro()->format("d/m/Y H:i:s")
        ));
    }
}

 ?>