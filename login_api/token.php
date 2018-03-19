<?php
// $arrHeader = getallheaders();
// $token = isset($arrHeader['token']) ? $arrHeader['token'] : ""; 
// echo $token; 
// var_dump($_POST);


$api_url = 'http://localhost:8080/login_api/logintoken.php';
$context = stream_context_create(array(
    'http' => array(
        'header' => "Authorization: Basic " . base64_encode($token),
    ),
));
$result = file_get_contents($api_url, false, $context);

?>