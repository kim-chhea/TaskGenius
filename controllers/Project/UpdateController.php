<?php 
require "../Backends/models/project.php";
if($id != null){
    $project = new Project($conn);
    $project->Update($id);
}
?>