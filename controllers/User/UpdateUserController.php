<?php 
require '../Backends/models/User.php' ;
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    echo json_encode($id);
    $user = new User($conn);
    $user->updateUser($id);
}

?>