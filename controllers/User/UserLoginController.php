<?php 
require  "../Backends/models/User.php";
use \Firebase\JWT\JWT;
require "./vendor/autoload.php";
$users = new User($conn);
$inputdata = json_decode(file_get_contents("php://input"), true);
$email = $inputdata['email'] ?? '';
$username = $inputdata['username'] ?? '';
$password = ($inputdata['password']) ?? '';
// validate user
$data =$users->validateLogin($email, $username,$password);
if(!empty($data))
{
    if ($email == $data['email'] &&  $username == $data['username'])
    {
   
         // Generate JWT token
         $key = "8120-jwt-taskgenius"; 
         $issuedAt = time();
         $expirationTime = $issuedAt + 3600000;  // Set token expiration time (1 hour)
         $payload = array(
             "email" => $email,
             "username" => $username,
             "iat" => $issuedAt,
             "exp" => $expirationTime
         );
         $jwt = JWT::encode($payload, $key,'HS256');
        setcookie("auth_token", $jwt, time() + 3600, "/", "", true, true);
        echo json_encode(["message"=> "you get autherization to use that API" , "token" => $jwt]);    

    }
    else
    {
        echo json_encode(["message"=> "you dont get autherization to use that API"]);
    }
}
else 
{
    echo json_encode(["error" => "User not found"]);
}



?>