<?php 
require "../Backends/models/project.php";
$project = new Project($conn);
$project->StoreData();

?>