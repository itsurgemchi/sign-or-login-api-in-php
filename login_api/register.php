<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array("error" => FALSE);

if (isset($_POST['firstname']) && isset($_POST['lastname']) &&isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phonenumber'])){

    $firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
	$phonenumber = $_POST['phonenumber'];

    if ($db->isUserExisted($email)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        $user = $db->storeUser($firstname, $lastname, $username, $email, $password, $phonenumber);
        if ($user) {
            $response["error"] = FALSE;
            $response["user"]["firstname"] = $user["firstname"];
            $response["user"]["lastname"] = $user["lastname"];
            $response["user"]["username"] = $user["username"];
            $response["user"]["email"] = $user["email"];
			$response["user"]["phonenumber"] = $user["phonenumber"];
            echo json_encode($response);
        } else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
?>

<?php

/* $encoded_header = base64_encode('{"alg": "HS256","typ": "JWT"}');
$encoded_payload = base64_encode('{"name":$firstname,"email": $lastname}');
$header_payload = $encoded_header . '.' . $encoded_payload;
$secret_key = 'secret';
$signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));
$jwt_token = $header_payload . '.' . $signature;
echo $jwt_token;  */
?>


<?php
/* $key = 'secert';
$header = [
           'typ' => 'JWT',
		   'alg' => 'HS256'
		];
$header = json_encode($header);		
$header = base64_encode($header); 
$payload = [
		    "firstname" = '$firstname',
			"lastname" = '$lastname',
			"username" = '$username',
			"email" = '$email',
			"phonenumber" = '$phonenumber'
			];
$payload = json_encode($header);	
$payload = base64_encode($header);
$signature = hash_hmac('sha256','$header.$payload', $key, true);
$signature = base64_encode($signature);
$token = "$header.$payload.$signature";
echo $token; */
?>

