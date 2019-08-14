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
            $this->setData($results[0]);
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
            $this->setData($results[0]);
        } else {
            throw new Exception("Login e/ou senha inválidos!");
        }
    }

    public function setData($data) {
        $this->setIdusuario($data["idusuario"]);
        $this->setDeslogin($data["deslogin"]);
        $this->setDessenha($data["dessenha"]);
        $this->setDtcadastro(new DateTime($data["dtcadastro"]));
    }

    public function insert() {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        $results = $sql->select("CALL sp_usuarios_insert(:login, :senha)", array(
            ":login" => $this->getDeslogin(),
            ":senha" => $this->getDessenha()
        ));

        if (count($results) > 0) {
            $this->setData($results[0]);
        }
    }

    public function update($login, $senha) {
        $this->setDeslogin($login);
        $this->setDessenha($senha);

        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        $sql->query("update tb_usuarios set deslogin = :login, dessenha = :senha where idusuario = :id;", array(
            ":login" => $this->getDeslogin(),
            ":senha" => $this->getDessenha(),
            ":id" => $this->getIdusuario()
        ));
    }

    public function delete() {
        $sql = new Sql("mysql:host=localhost;dbname=dbphp7", "root", "");

        $sql->query("delete from tb_usuarios where idusuario = :id;", array(
            ":id" => $this->getIdusuario()
        ));
    }

    public function __construct($login = "", $senha = "") {
        $this->setDeslogin($login);
        $this->setDessenha($senha);
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