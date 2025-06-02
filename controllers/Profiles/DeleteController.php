<?php 
require "../Backends/models/profile.php";
$profile = new profile($conn);
$profile->delete($id);
?>