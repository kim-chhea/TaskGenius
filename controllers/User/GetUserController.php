<?php
require '../Backends/models/User.php';
$users = new User($conn);
$result = $users->getUser();
echo json_encode(["message" => "get users successfully" ,"status" => 200 , "data" => $result ]);
?>