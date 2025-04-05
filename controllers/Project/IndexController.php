<?php
require "../Backends/models/project.php";
$project = new Project($conn);
$result = $project->Index();
print_r (json_encode($result));

?>
