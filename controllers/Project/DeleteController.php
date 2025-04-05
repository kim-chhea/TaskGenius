<?php 
require "../Backends/models/project.php";
if(!empty($id))
{
$project = new Project($conn);
$project->Delete($id) ;
}

?>x