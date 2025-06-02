<?php 
require "../Backends/models/Tasks.php";
if(!empty($id))
{
    $task = new tasks($conn);
  
    $results = $task->Update($id);
}
else
{
  echo json_encode(['message' => 'ID not found']);
}

?>