<?php 
Class Project{
    private $project_id;
    private $project_name;
    private $project_description;
    private $project_status;
    private $task_id;
    private $conn;
    private $data;

 public function __construct($database)
{
 $this->conn = $database;
 $this->data = json_decode(file_get_contents('php://input'));
}

//get list of data
public function Index()
{
    try
    {
    $query = "SELECT 
  projects.project_id AS project_id,
  projects.project_name AS project_name,
  projects.project_description AS project_description,
  projects.project_status AS project_status,
  projects.created_by,
  projects.created_at,
  projects.updated_at,
  tasks.task_id AS task_id,
  tasks.task_name AS task_name,
  tasks.task_description AS task_description,
  tasks.task_status AS task_status,
  tasks.due_date ,
  tasks.created_at  AS tasks_created_at,
  tasks.updated_at AS tasks_updated_at
FROM projects  LEFT JOIN tasks ON projects.project_id = tasks.project_id;";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt ->fetchALL(PDO::FETCH_ASSOC);
    }
    
        catch(Exception $e)
    {
        echo "Error: " . $e->getMessage();
    }
}

//Sotre Data
public function StoreData()
{
   try{
    $query = "INSERT INTO projects (project_name, project_description, project_status ,created_by) VALUES (:project_name ,:project_description, :project_status ,:created_by)";
    $stmt = $this->conn->prepare($query);
    $result = $stmt->execute([
        ':project_name' => $this->data->project_name,
        ':project_description' => $this->data->project_description,
        ':project_status' => $this->data->project_status,
        ':created_by' => $this->data->created_by
    ]);
    if ($result) 
    {
    echo json_encode(['message' => 'Project inserted successfully']);
    }   
    else
    {
    echo json_encode(['message' => 'Error inserting projects']);
    }
   }
   catch(Exception $e)
   {
    echo "Error". $e->getMessage();
   }
}
//Get data by ID
public function GetbyID($id)
 {
    try
    {
       $query = "SELECT 
  projects.project_id AS project_id,
  projects.project_name AS project_name,
  projects.project_description AS project_description,
  projects.project_status AS project_status,
  projects.created_by,
  projects.created_at,
  projects.updated_at,
  tasks.task_id AS task_id,
  tasks.task_name AS task_name,
  tasks.task_description AS task_description,
  tasks.task_status AS task_status,
  tasks.due_date ,
  tasks.created_at  AS tasks_created_at,
  tasks.updated_at AS tasks_updated_at
  FROM projects LEFT JOIN tasks ON projects.project_id = tasks.project_id WHERE projects.project_id  = :id";
       $stmt= $this->conn->prepare($query);
       $result = $stmt->execute([
       ':id' => $id
     ]);
     return $stmt->fetchALL(PDO::FETCH_ASSOC); 
    }
    catch(Exception $e)
    {
        echo "Error: " . $e->getMessage();
    }

}


//delete data from database
public function Delete($id){
    try
    {
        $query = "DELETE FROM projects WHERE project_id = :id";
        $smtm = $this->conn->prepare($query);
        $result = $smtm->execute([":id"=> $id] );
        if ($result) {
            echo json_encode(['message' => 'Project deleted successfully']);
        } else {
            echo json_encode(['message' => 'Error deleting project']);
        }
    }
    catch(Exception $e)
    {
        echo "Error". $e->getMessage();
    }

}
public function Update($id)
{
    try{
        $query = "UPDATE projects SET project_name = :project_name, project_description = :project_description , project_status= :project_status WHERE project_id = :project_id";
        $stmt= $this->conn->prepare($query);
        $result = $stmt->execute([
        ":project_name" => $this->data->project_name,
        ":project_description" => $this->data->project_description,
        ":project_status" => $this->data->project_status,
        ":project_id" => $id,
        ]);
        if ($result) {
            echo json_encode(['message' => 'Project updated successfully']);
        } else {
            echo json_encode(['message' => 'Error updating project']);
        }

    }
    catch(Exception $e)
    {
        echo "Error".$e->getMessage();
    }
}
}
?>