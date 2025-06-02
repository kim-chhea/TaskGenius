<?php
 require "../Backends/models/project.php";
if($id)
{
$project = new Project($conn);
$data = $project->GetbyID($id);   
if($data == null){
    echo json_encode(['message' => 'project not found' ,"status" => 404]);
 }
 else{
    print_r (json_encode(["message"=> "get project successfully", "status" => 200 , "data" => $data]));
 }

}




?>