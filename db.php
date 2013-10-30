<?php
    class DB {
        public $conn;
        public $dbname;

        public function __construct() {
        }

        public function connect($ip,$username,$password,$dbname) {
            $this->dbname = $dbname;

            $this->conn = mysqli_connect($ip, $username, $password) or die(mysql_error());
            mysqli_select_db($this->conn,$dbname);
        }

        public function resetDatabase() {
            mysqli_query($this->conn,"DROP DATABASE $this->dbname");
            mysqli_query($this->conn,"CREATE DATABASE $this->dbname");
            mysqli_select_db($this->conn,$this->dbname);
            $this->createTables();
        }

        public function createTables() {
            mysqli_query($this->conn,"CREATE TABLE users (username VARCHAR(255),passwordhash VARCHAR(255),created DATETIME)");
        }

        public function addUser($name,$password) {
            $hash = crypt($password);
            $now = date( 'Y-m-d H:i:s');
            if ($this->getUser($name) != null) throw new Exception("Username already exists!");
            mysqli_query($this->conn,"INSERT INTO users VALUES ('$name','$hash','$now')");
        }

        public function authenticate($name,$password) {
            $hash = crypt($password);
            $user = $this->getUser($name);
            return crypt($password, $user['passwordhash']) === $user['passwordhash'];
        }

        public function getUser($name) {
            $result = mysqli_query($this->conn,"SELECT * FROM users WHERE username='$name'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0];
        }

        public function getUsers() {
            $result = mysqli_query($this->conn,"SELECT * FROM users");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            return $data;
        }

        public function close() {
            mysqli_close($this->conn);
        }
    }
    
?>
