<?php
Class tasks
{
    private $conn;
    private $task_name;
    private $task_description;
    private $task_status;
    private $project_id;
    private $task_id;
    private $data;
    public function __construct($conn){
        $this->conn = $conn;
        $this->data = json_decode(file_get_contents('php://input'));
    }
    public function Index()
    {
    try
    {
    $query = "SELECT * FROM tasks";
    $stmt = $this->conn->query($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($result))
    {
        echo json_encode(['message' => 'Tasks are empty']);
    }
    else
    {
    echo json_encode(["message" => "get tasks successfully" ,"status" => 200 , "data" => $result ]);
    } 
    }
    catch(Exception $e)
    {
        echo "Error".$e->getMessage();
    }
    
    
    }

    //get data by ID
    public function getByID($id){

    try{
        $query = "SELECT * FROM tasks WHERE task_id =  :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([":id"=> $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result))
        {
        echo json_encode(['message' => 'Tasks are not found' , "status" => 404]);
        }
        else
        {
        echo json_encode(["message" => "get task successfully" ,"status" => 200 , "data" => $result ]);
        } 
    }
    catch(Exception $e)
    {
        echo "Errorr". $e->getMessage();
    }
    }

    //Create data
    public function Store()
    {   
        try
        {
        $query = "INSERT INTO tasks (task_name ,  task_description , task_status , due_date , project_id) VALUE (:task_name , :task_description , :task_status ,:due_date , :project_id) ";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([
            ":task_name" => $this->data->task_name,
            ":task_description" => $this->data->task_description,
            ":task_status" => $this->data->task_status,
            ":due_date"   => $this->data->due_date,
            ":project_id" => $this->data->project_id
            ]); 
         if($result)
         {
            echo json_encode(["message" => "Task inserted successfully" , "status" => 201]);
         }
         else
         {
            echo json_encode(["message" => "Error inserted task " , "status" => 400]);
         }  
        }
        
         catch(Exception $e)
         {
            echo "Error". $e->getMessage();
         }

    }
    //update data
    public function Update($id)
    { 
        try
        {
         $query = " UPDATE tasks SET task_name = :task_name , task_description = :task_description , task_status = :task_status , due_date = :due_date ,project_id = :project_id  WHERE task_id = :id";
         $stmt = $this->conn->prepare($query);
         
         $result = $stmt->execute
          ([
            ":task_name" => $this->data->task_name,
            ":task_description" => $this->data->task_description,
            ":task_status" => $this->data->task_status,
            ":due_date" => $this->data->due_date,
            ":project_id" => $this->data->project_id,
            ":id" => $id
         ]);
         
            if ($result)
            {
                echo json_encode(["message"=> "Task updated successfully", "status" => 200]);
            }
            else
            {
                echo json_encode(["message" => "Task not found", "status" => 404]);

            }
        }
        catch(Exception $e)
         {
            echo "Error". $e->getMessage();
         }
        
    }

    public function Delete($id)
    {   try
        {
        $query = "DELETE FROM tasks WHERE task_id = :id";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([":id" => $id]);
            if($result && $stmt->rowCount() > 0)
            {
                echo json_encode(["message" => "Task deleted successfully", "status" => 200]);
            }
            else
            {
                echo json_encode(["message" => "Error deleting task , task not found", "status" => 404]);
            }
        }
        catch(Exception $e)
        {
            echo "Error". $e->getMessage();
        }
    }
}



?>