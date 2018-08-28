<?php
 
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['mobileNo']) && isset($_POST['password']) && isset($_POST['college'])&&isset($_POST['name']) && isset($_POST['email'])) {
	$phone = $_POST['mobileNo'];
    $pass = $_POST['password'];                                 //unhashed password
    $collegename = $_POST['college'];
    $name = $_POST['name'];
    $email = $_POST['email'];
	

	$password = password_hash($pass,PASSWORD_DEFAULT);		 	// encrypted password
	 
    // check if user is already existed with the same mobile
    if ($db->isUserExisted($mobileNo)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "Username already exists with " . $mobileNo;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $email, $phone, $collegename, $password, $pass);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"] = $user["user"];
            $response["user"]["mobileNo"] = $user["mobileNo"];
            $response["user"]["password"] = $user["password"];
            $response["user"]["collegeName"] = $user["college"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];           

            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (phonenumber, password,collegename ,name or email) is missing!";
    echo json_encode($response);
}
?>
