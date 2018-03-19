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
        echo json_encode($response);
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