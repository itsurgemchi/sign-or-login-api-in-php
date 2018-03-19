<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array("error" => FALSE);

if (isset($_POST['email']) && isset($_POST['password'])) {

	$email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user != false) {
        $response["error"] = FALSE;
        $response["user"]["id"] = $user["id"];
		$response["user"]["firstname"] = $user["firstname"];
		$response["user"]["lastname"] = $user["lastname"];
		$response["user"]["username"] = $user["username"];
		$response["user"]["email"] = $user["email"];
		$response["user"]["phonenumber"] = $user["phonenumber"];

		$encoded_header = base64_encode('{"alg": "HS256","typ": "JWT"}');
		
		$payload=[$response];
		$payload_encoded = base64_encode(json_encode($payload));
				
		$secret_key = 'login';
		$signature = base64_encode(hash_hmac('sha256', $payload_encoded, $secret_key, true));
		$token = "$encoded_header.$payload_encoded.$signature";
        echo json_encode($response) ."<br/>".$token;
		
		$sql = "INSERT INTO logintoken('api_token') VALUE ('$token')";
	
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}


?>
