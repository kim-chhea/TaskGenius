<?php 
require  "../Backends/models/User.php";
$users = new User($conn);
$users->CreateData();

?>