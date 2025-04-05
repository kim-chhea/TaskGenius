<?php 
require '../Backends/models/User.php' ;
if($id != null)
{
    $user = new User($conn);
    $user->updateUser($id);
    
}

?>