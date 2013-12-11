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
            mysqli_query($this->conn,"CREATE TABLE users (id MEDIUMINT NOT NULL AUTO_INCREMENT, email VARCHAR(255), display VARCHAR(255),passwordhash VARCHAR(255),created DATETIME,PRIMARY KEY (id))");
            mysqli_query($this->conn,"CREATE TABLE user_game_data (id MEDIUMINT NOT NULL AUTO_INCREMENT, user_id MEDIUMINT NOT NULL, property VARCHAR(255), value VARCHAR(255),PRIMARY KEY (id))");
            mysqli_query($this->conn,"CREATE TABLE server_list (public_address CHAR(16) NOT NULL, heartbeat TIMESTAMP NOT NULL, PRIMARY KEY (public_address))");
            mysqli_query($this->conn,"CREATE TABLE server_clients (public_address CHAR(16) NOT NULL, private_address CHAR(16) NOT NULL, heartbeat TIMESTAMP NOT NULL, PRIMARY KEY (private_address))");
        }

        public function addUser($email,$password) {
            $hash = crypt($password);
            $now = date( 'Y-m-d H:i:s');
            if ($this->findUser($name) != null) throw new Exception("Username already exists!");
            mysqli_query($this->conn,"INSERT INTO users VALUES (NULL,'$email','','$hash','$now')");
        }

        public function getProperty($user,$property) {
            $result = mysqli_query($this->conn,"SELECT * FROM user_game_data WHERE user_id=$user AND property='$property'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0]['value'];
        }

        public function setProperty($user,$property,$value) {
            $existing = $this->getProperty($user,$property);
            if ($existing == null) {
                mysqli_query($this->conn,"INSERT INTO user_game_data VALUES (NULL,$user,'$property','$value')");
            } else {
                mysqli_query($this->conn,"UPDATE user_game_data SET value='$value' WHERE user_id=$user AND property='$property'");
            }
        }

        public function getDatabaseTime() {
            $result = mysqli_query($this->conn,"SELECT now()");
            $data = mysqli_fetch_all($result);
            return $data[0][0];
        }

        public function getActiveServers() {
            $now = strtotime($this->getDatabaseTime());
            $result = mysqli_query($this->conn,"SELECT * FROM server_list");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return [];

            $activeServers = array();
            foreach ($data as $row) {
                $date = strtotime($row['heartbeat']);
                $delta = $now - $date;
                if ($delta <= 10) $activeServers[] = $row['public_address'];
            }
            return $activeServers;
        }

        public function getClients($publicAddress) {
            $now = strtotime($this->getDatabaseTime());
            $result = mysqli_query($this->conn,"SELECT * FROM server_clients WHERE public_address='$publicAddress'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;

            $activeClients = array();
            foreach ($data as $row) {
                $date = strtotime($row['heartbeat']);
                $delta = $now - $date;
                if ($delta <= 10) $activeClients[] = $row['private_address'];
            }
            return $activeClients;
        }

        public function getClient($publicAddress,$privateAddress) {
            $result = mysqli_query($this->conn,"SELECT * FROM server_clients WHERE public_address='$publicAddress' AND private_address='$privateAddress'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0]['heartbeat'];
        }

        public function addClient($publicAddress,$privateAddress) {
            $existing = $this->getClient($publicAddress,$privateAddress);

            if ($existing == null) {
                mysqli_query($this->conn,"INSERT INTO server_clients VALUES('$publicAddress','$privateAddress',now())");
            } else {
                mysqli_query($this->conn,"UPDATE server_clients SET heartbeat=now() WHERE public_address='$publicAddress' AND private_address='$privateAddress'");
            }
        }

        public function findServer($publicAddress) {
            $result = mysqli_query($this->conn,"SELECT heartbeat FROM server_list WHERE public_address='$publicAddress'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0]['heartbeat'];
        }

        public function refreshServer($publicAddress) {
            $heartbeat = $this->findServer($publicAddress);
            if ($heartbeat == null) {
                mysqli_query($this->conn,"INSERT INTO server_list VALUES ('$publicAddress',now())");
            } else {
                mysqli_query($this->conn,"UPDATE server_list SET heartbeat=now() WHERE public_address='$publicAddress'");
            }
        }

        public function authenticate($email,$password) {
            $hash = crypt($password);
            $user = $this->findUser($email);
            return crypt($password, $user['passwordhash']) === $user['passwordhash'];
        }

        public function findUser($email) {
            $result = mysqli_query($this->conn,"SELECT * FROM users WHERE email='$email'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0];
        }

        public function setDisplayName($email,$display) {
            mysqli_query($this->conn,"UPDATE users SET display='$display' WHERE email='$email'");
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
