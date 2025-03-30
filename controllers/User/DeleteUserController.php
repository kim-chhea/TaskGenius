<?php
if ($id != null){
    require '../Backends/models/User.php';
    $user = new User($conn);
    $result = $user->deleteUser($id);
}

?>