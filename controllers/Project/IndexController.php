<?php
require "../Backends/models/project.php";
$project = new Project($conn);
$result = $project->Index();
print_r (json_encode(["message"=> "get projects successfully", "status" => 200,"data" => $result]));

?>
