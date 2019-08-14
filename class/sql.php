<?php

class Sql extends PDO {
    private $conn;

    public function __construct($connectionString = "mysql:host=localhost;dbname=dbphp7", $userName = "root", $passWord = "") {
    	$this->conn = new PDO($connectionString, $userName, $passWord);
    }

    private function setParams($statment, $parameters = array()) {
    	foreach ($parameters as $key => $value) {
    		$this->setParam($statment, $key, $value);
    	}
    }

    private function setParam($statment, $key, $value) {
    	$statment->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array()) {
    	$stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);
        
        $stmt->execute();

	    return $stmt;
    }

    public function select($rawQuery, $params = array()) {
        $this->query($rawQuery, $params);

        $stmt = $this->query($rawQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

 ?>