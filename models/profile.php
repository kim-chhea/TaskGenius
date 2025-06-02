<?php 
class profile{
    private $conn;
    private $data;
    private $profile_background;
    private $profile_cover;
    private $user_id;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->data = json_decode(file_get_contents('php://input'));
    }
    public function show($id)
    {  try
        {
            $query = "SELECT * FROM user_profiles WHERE profile_id = :profile_id";
           $stmt = $this->conn->prepare($query);
           $stmt->execute([
            ":profile_id" => $id
           ]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           if(!$result && $stmt->rowCount() <= 0 )
           {
            echo json_encode(["message" => " user profile not found" , "status" => 404]);
            return;
           }
           echo json_encode(["message" => "get user profile successfully" , "status" => 200,"data" => $result]);

        }
        catch(Exception $e)
        {
            echo json_encode(["message" => "internal server error" , "status" => 500,"error" => $e->getMessage()]);

        }


    }
    

    public function index()
    {
        try
        {
           $query = "SELECT * FROM user_profiles";
           $stmt = $this->conn->prepare($query);
           $stmt->execute();
           $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
           if(!$result && $stmt->rowCount() <= 0 )
           {
            echo json_encode(["message" => " user profile not found" , "status" => 404]);
            return;
           }
           echo json_encode(["message" => "get user profile successfully" , "status" => 200,"data" => $result]);

        }
        catch(Exception $e)
        {
            echo json_encode(["message" => "internal server error" , "status" => 500,"error" => $e->getMessage()]);

        }
    }
    public function store()
    {
        try
        {
          $query = "INSERT INTO user_profiles (user_id , profile_background,profile_cover) value(:user_id ,:profile_background,:profile_cover)";
           $stmt = $this->conn->prepare($query);
           $result  = $stmt->execute([
            ":user_id" => $this->data->user_id,
            ":profile_background" => $this->data->profile_background,
            ":profile_cover" => $this->data->profile_cover,
           ]);
           
           if(!$result && $stmt->rowCount() <= 0 )
           {
            echo json_encode(["message" => "fail to insert user profile" , "status" => 400]);
            return;
           }
           echo json_encode(["message" => "inserted user profile successfully" , "status" => 201]);

        }
        catch(Exception $e)
        {
            echo json_encode(["message" => "internal server error" , "status" => 500,"error" => $e->getMessage()]);

        }
    }


    public function update($id)
    {
        try
        {
          $query = "UPDATE user_profiles SET user_id = :user_id , profile_background = :profile_background , profile_cover = :profile_cover WHERE profile_id = :profile_id";
           $stmt = $this->conn->prepare($query);
           $result  = $stmt->execute([
            ":user_id" => $this->data->user_id,
            ":profile_background" => $this->data->profile_background,
            ":profile_cover" => $this->data->profile_cover,
            ":profile_id" => $id,
           ]);
           
        if (!$result) {
            echo json_encode(["message" => "Fail to execute SQL", "status" => 400]);
            return;
        }
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(["message" => "No profile found with that ID", "status" => 404]);
            return;
        }
           echo json_encode(["message" => "updated user profile successfully" , "status" => 201]);

        }
        catch(Exception $e)
        {
            echo json_encode(["message" => "internal server error" , "status" => 500,"error" => $e->getMessage()]);

        }
    }

    public function delete($id)
    {
        try
        {
           $query = "DELETE FROM user_profiles WHERE profile_id = :profile_id";
           $stmt = $this->conn->prepare($query);
           $result = $stmt->execute([
            ":profile_id" => $id
           ]);
           
           if(!$result )
           {
            echo json_encode(["message" => " user profile not found" , "status" => 404]);
            return;
           }
           if($stmt->rowCount() <= 0 )
           {
            echo json_encode(["message" => " user profile not found" , "status" => 404]);
            return;
           }
           echo json_encode(["message" => "user profile deleted successfully" , "status" => 200]);

        }
        catch(Exception $e)
        {
            echo json_encode(["message" => "internal server error" , "status" => 500,"error" => $e->getMessage()]);

        }
    }
}

?>