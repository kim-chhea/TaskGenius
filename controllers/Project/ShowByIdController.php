<?php
 require "../Backends/models/project.php";
if($id)
{
$project = new Project($conn);
$data = $project->GetbyID($id);   
if($data == null){
    echo json_encode(['message' => 'No data found']);
 }
 else{
    print_r (json_encode($data));
 }

}




?>