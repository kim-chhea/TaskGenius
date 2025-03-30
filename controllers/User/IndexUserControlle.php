<?php 
require '../Backends/models/User.php' ;
if($id != null)
{
    $user = new User($conn);
    $result =$user->indexUser($id);
    if ($result) {
        echo json_encode($result);  // Return the result as JSON
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}

?>