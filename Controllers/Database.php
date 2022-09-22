<?php
require_once "Config.php";

class Database {
    private $serverName = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbName = DB_NAME; 

    private $isConnected = false;
    private $conn;
    private $dsn;
    private $error;
    private $stmt ="";

    public function __construct() {
        $this->dsn = "mysql:host=".$this->serverName.";dbname=".$this->dbName;
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try {
            $this->conn = new PDO($this->dsn,$this->username,$this->password,$options);
            $this->isConnected = true;
            // echo ($this->isConnected) ? "is connected" : "is not connected";
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            $this->isConnected = false;
        }
    }

    public function query($sql) {
        $this->stmt = $this->conn->prepare($sql);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function statement() {
        return $this->stmt;
    }

    public function fetch() {
        return $this->stmt->fetch();
    }
    
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetchObject() {
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function connected(): bool {
        return $this->isConnected;
    }

    public function getError() {
        return $this->error;
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    function closeStmt() {
        return $this->stmt->closeCursor();
    }
}
?>