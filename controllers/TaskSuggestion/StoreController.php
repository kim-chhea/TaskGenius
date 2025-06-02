<?php 
require "../Backends/models/suggestion.php";
$suggestion = new Suggestion($conn);
$suggestion->store();
?>