<?php 
class Suggestion
{
    private $suggestion_id;
    private $suggestion_text;
    private $conn;
    private $formdata;
    public function __construct($database)
    {
        $this->conn = $database;
        $this->formdata = json_decode(file_get_contents("php://input"));
    }
    public function index()
    {
      try
      {
         $query = "SELECT * FROM task_suggestions";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         $data = $stmt->fetchALL(PDO::FETCH_ASSOC);
         if(!$data)
         {
          echo json_encode([ "message" => "suggestions not found" , "status"=> 404 ]);
         }
         echo json_encode(["message" => "get suggestions successfully" ,"status" => 200 ,  "data" => $data]);
      }
      catch(Exception $e)
      {
        echo json_encode(["status" => 500 , "message" => $e->getMessage() ]);
      }
    }



    public function show($id)
    {
      try
      {
         $query = "SELECT * FROM task_suggestions WHERE suggestion_id = ?";
         $stmt = $this->conn->prepare($query);
         $stmt->execute([$id]);
         $data = $stmt->fetch(PDO::FETCH_ASSOC);
         if(!$data && $stmt->rowCount() <= 0)
         {
          echo json_encode(["message" => "suggestions not found" ,"status"=> 404 ]);
         }
         else
         {
          echo json_encode([ "message" => "get suggestions successfully" , "status" => 200 ,"data" => $data]);
         }
         
      }
      catch(Exception $e)
      {
        echo json_encode(["status" => 500 , "message" => $e->getMessage() ]);
      }
    }




    public function destroy($id)
    {
      try
      {
         $query = "DELETE FROM task_suggestions WHERE suggestion_id = :id";
         $stmt = $this->conn->prepare($query);
         $data = $stmt->execute([":id"  => $id]);
         if(!$data)
         {
          echo json_encode(["message" => "Error to deleting" , "status"=> 404 , ]);
          return;
         }
         if ($stmt->rowCount() === 0) {
          echo json_encode(["message" => "No suggestion found with that ID", "status" => 404]);
          return;
         }
         echo json_encode(["message" => "suggestions was deleted successfully" ,"status" => 200]);

      }
      catch(Exception $e)
      {
        echo json_encode(["status" => 500 , "message" => $e->getMessage() ]);
      }
    }


    public function store()
    {
        try 
        {
            $querry = "INSERT INTO task_suggestions (suggestion_text , task_id ) value (:suggestion_text , :task_id)";
            $stmt = $this->conn->prepare($querry);
            $result = $stmt->execute
            ([
            ":suggestion_text" => $this->formdata->suggestion_text, 
            ":task_id" => $this->formdata->task_id
            ]);
            if(!$result)
            {
                echo json_encode(["message" => "Error to insert suggestions" , "status" => 404 ]);
            }
              echo json_encode(["message" => "suggestions inserted successfully", "status" => 201]);   
            
            
        }
        catch(Exception $e)
        {
            echo json_encode(["status" =>500, "message" => $e->getMessage()]);
        }
        
    }


    public function update($id )
    {
        try
        {

        $query = "UPDATE task_suggestions SET suggestion_text = :suggestion_text , task_id = :task_id WHERE suggestion_id = :suggestion_id ";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute
        ([
        ":suggestion_text" => $this->formdata->suggestion_text,
        ":task_id"  => $this->formdata->task_id,
        ":suggestion_id"  => $id,
        ]);
        if(!$result)
        {
           echo json_encode(["message" => "Error to update suggestions" , "status" => 404 ]);
           return;
        }
        // if ($stmt->rowCount() === 0) {
        //   echo json_encode(["message" => "No suggestion found with that ID", "status" => 404]);
        //   return;
        //  }
        echo json_encode(["message" => "suggestions updated successfully" ,"status" => 200 ]);
        }
        catch(Exception $e)
        {
            echo json_encode(["status" => 500 , "message" => $e->getMessage()]);
        }
    }
}

?>