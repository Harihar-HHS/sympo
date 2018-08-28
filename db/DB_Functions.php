<?php
 
class DB_Functions {
 
    private $conn;
 
    function __construct() {
        require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $phone, $collegename, $password, $unhashed_pass) {
        $uuid = uniqid('', true);
		$singleevent = 0;
 
        $stmt = $this->conn->prepare("INSERT INTO register(mobileNo, password,college,name,email) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss",$phone, $password,  $collegename,$name, $email );
        $result = $stmt->execute();
        $stmt->close();
		
		$user = $this->getUserByMobileAndPassword($phone, $unhashed_pass);
		$uid = $user['mobileNo'];
		
		$stmt1 = $this->conn->prepare("INSERT INTO events(`mobileNo`, `GoodWillHunting`, `TheGameOfCodes`, `Predestination`, `TheDigitalFortress`, `TheSecretSociety`, `UnicornOfSilicon`, `FishBowlConversation`, `Inquizitive`, `MiniProject`, `PresentationFrankenstein`) VALUES(?,?,?,?,?,?,?,?,?,?,?");
        $stmt1->bind_param("siiiiiiiiii", $uid, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent, $singleevent);
        $result1 = $stmt1->execute();
        $stmt1->close();
 
        // check for successful store
        if ($result && $result1) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE mobileNo = ?");
            $stmt->bind_param("s", $mobileNo);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
	
 	public function getUserByMobileAndPassword($phone, $password) {
		
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE mobileNo = ?");
		$stmt->bind_param("s", $phone);
		
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			
            // verifying user password
			$dbPass = $user['password'];
			
            // check for password equality
	
            if(password_verify($password,$dbPass)) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return json_encode("1");
        }
    }
	
	public function getUserEvents($phone) {
		
		$user = $this->getUserByMobile($phone);
		$uid = $user['mobileNo'];
 
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE mobileNo = ?");
 
        $stmt->bind_param("i", $uid);
 
        if ($stmt->execute()) {
            $eventslist = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
			return $eventslist;
            }
		else {
            return json_encode("2");
        }
    }
 
    /**
     * Check user exists or not
     */
    public function isUserExisted($phone) {
        $stmt = $this->conn->prepare("SELECT mobileNo from users WHERE mobileNo = ?");
 
        $stmt->bind_param("s", $phone);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
		
	 public function getUserByMobile($phone) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE mobileNo = ?");
 
        $stmt->bind_param("s", $phone);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			
			$mailId = $user['mobileNo'];
			
            // check for e-mail equality
            if ($mailId == $phone) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return json_encode("3");
        }
    }
 
}
 