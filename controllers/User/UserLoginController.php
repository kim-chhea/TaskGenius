<?php 
require  "../Backends/models/User.php";
if($ID !=null ){
$users = new User($conn);
$data =$users->validate($ID);
$inputdata = json_decode(file_get_contents('php://input'),true);
if (!isset($inputdata['email'], $inputdata['username'], $inputdata['password'])) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}
$email = $inputdata['email'];
$username = $inputdata['username'];
$password = $inputdata['password'];
// echo $ID;
if(!empty($data))
{

 if ($email == $data['email'] &&  $username == $data['username'] &&  $password == $data['password'])
 {
    echo json_encode(["message"=> "you get autherization to use that API"]);
 }
 else{

    echo json_encode(["message"=> "you dont get autherization to use that API"]);
    $token = bin2hex(random_bytes(32));
    echo json_encode(['token'=> $token]);
    setcookie("auth_token", $token, time()+ 3600, "/","",true,true);
    echo json_encode($token);
 }
}
else 
{
    echo json_encode(["error" => "User not found"]);
}
}


?>