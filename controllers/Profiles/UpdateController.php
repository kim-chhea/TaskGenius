<?php 
require "../Backends/models/profile.php";
$profile = new profile($conn);
$profile->update($id);
?>