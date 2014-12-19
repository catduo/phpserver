<?php
    class DB {
        public $conn;
        public $dbname;

        public function __construct() {
        }
		
		public function ping($test, $test2){
			$stmt = mysqli_prepare($this->conn, "SELECT PasswordHash FROM games.player_accounts WHERE Username= ?");
			mysqli_stmt_bind_param($stmt, 's', $test2);
			mysqli_stmt_execute($stmt);
    		$result = $stmt->get_result();
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
			echo '\n';
			echo $data[0]['PasswordHash'];
			echo '\n';
			$options = [
				'salt' => '4',
			];
			$hash = password_hash($test, PASSWORD_DEFAULT, $options);
			echo $hash;
            if (count($data) == 0) return 'true';
			return 'false';
		}

        public function connect($ip,$username,$password,$dbname) {
            $this->dbname = $dbname;

            $this->conn = mysqli_connect($ip, $username, $password) or die(mysql_error());
            mysqli_select_db($this->conn,$dbname);
        }
		
		public function getDeviceID($jid, $deviceType, $deviceInfo){
			$stmt = mysqli_prepare($this->conn, "INSERT INTO games.devices SET JoviosID= ?, DeviceType= ?,DeviceInfo=?");
			mysqli_stmt_bind_param($stmt, 'sss', $jid, $deviceType, $deviceInfo);
			mysqli_stmt_execute($stmt);
            return mysqli_insert_id($this->conn);
		}
		
		public function checkUsername($checkUsername){
			$stmt = mysqli_prepare($this->conn, "SELECT * FROM games.player_accounts WHERE Username= ?");
			mysqli_stmt_bind_param($stmt, 's', $checkUsername);
			mysqli_stmt_execute($stmt);
    		$result = $stmt->get_result();
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return 'true';
			return 'false';
		}
		
		public function registerEmail(){
			
		}
		
		public function loginEmail(){
			
		}
		
		public function getGames(){
			
		}
		
		public function saveGame(){
			
		}
		
		public function saveGameStat(){
			
		}
		
		public function loadGameStat(){
			
		}
		
		public function saveSystemStat(){
			
		}
		
		public function newGame(){
			
		}

		
		public function setInvite(){
			
		}

		
		public function report(){
			
		}
		/*
        public function addUser($email,$password) {
            $hash = crypt($password);
            $now = date( 'Y-m-d H:i:s');
            if ($this->findUser($name) != null) throw new Exception("Username already exists!");
            mysqli_query($this->conn,"INSERT INTO users VALUES (NULL,'$email','','$hash','$now')");
        }

        public function newUser() {
            $now = date( 'Y-m-d H:i:s');
            mysqli_query($this->conn,"INSERT INTO users VALUES (NULL,'','','','$now')");
            $result = mysqli_query($this->conn,"SELECT * FROM users WHERE created = '$now'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0]['user_id'];
        }

        public function getStat($user,$property) {
            $result = mysqli_query($this->conn,"SELECT * FROM games.games_data WHERE user_id=$user AND property='$property'");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if (count($data) == 0) return null;
            return $data[0]['value'];
        }

        public function saveStat($user,$property,$value) {
            $existing = $this->getStat($user,$property);
            if ($existing == null) {
                mysqli_query($this->conn,"INSERT INTO user_game_data VALUES (NULL,$user,'$property','$value')");
            } else {
                mysqli_query($this->conn,"UPDATE user_game_data SET value='$value' WHERE user_id=$user AND property='$property'");
            }
        }
	
	public function getGames($user){
		
	}

	public function saveGame($user, $gameID, $gameData){
		
	}
	
	public function setInvites($user, $gameID){

	}

	public function loadGame($user, $gameID){

	}

	public function newGame($user, $gameID){
	
	}

	public function getDeviceID($user, $gameID){

	}

	public function checkUsername($user, $username){

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
		 
		 */
    
    }
?>
