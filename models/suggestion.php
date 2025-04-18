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
        $this->formdata = json_decode(file_get_contents("php:\\input"));
    }
    public function index
    {
      try
      {
         $query = "SELECT * FROM task_suggestions";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $data = $stmt->fetchALL(PDO::FETCH_ASSOC);
         if(!$data)
         {
          echo (json_encode(["status"=> 404 , "message" => "data not found"]));
         }
         echo json_encode(["status" => 200 , "message" => "get data successfully" , "data" => $data]);
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
         return $data = $stmt->fetch(PDO::FETCH_ASSOC);
         if(!$data)
         {
          echo (json_encode(["status"=> 404 , "message" => "data not found"]));
         }
         echo json_encode(["status" => 200 , "message" => "get data successfully" , "data" => $data]);
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
         $query = "DELETE * FROM task_suggestions WHERE suggestion_id = :id";
         $stmt = $this->conn->prepare($query);
         $stmt->execute([":id"  => $id]);
         return $data = $stmt->fetchALL(PDO::FETCH_ASSOC);
         if(!$data)
         {
          echo (json_encode(["status"=> 404 , "message" => "Error to deleting"]));
         }
         echo json_encode(["status" => 200 , "message" => "data was deleted successfully" , "data" => $data]);
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
                echo json_encode(["status" => 404 , "message" => "Error to insert data"]);
            }
            echo json_encode(["status"=> 201 , "message" => "data inserted successfully"]);   
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
        $query = "UPDATE task_suggestion SET suggestion_text = :suggestion_text , task_id = :task_id WHERE suggestion_id = :suggestion_id ";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute
        ([
        ":suggestion_text" => $this->formdata->suggestion_text,
        ":suggest_id"  => $this->formdata->suggestion_id,
        ":task_id"  => $this->formdata->task_id
        ]);
        if(!$result)
        {
            echo json_encode(["status" => 404 , "message" => "Error to update data"]);
        }
        echo json_encode(["status" => 200 , "message" => "data updated successfully"]);
        }
        catch(Exception $e)
        {
            echo json_encode(["status" => 500 , "message" => $e->getMessage()]);
        }
    }
}

?>