<?php
Class User{
    private $username;
    private $email;
    private $password;
    private $conn;
    private $data;
    public function __construct($db)
    {
       
        $this->conn = $db;
        $this->data = json_decode(file_get_contents('php://input'));
        //   reads the raw JSON data from the request body.
    }
    public function getUser()
    {   
        try
        {
        $query = "SELECT * FROM Users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC); 
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        
    }
    public function validateLogin($email, $username, $password)
    {
        try
        {
           $query = "SELECT * FROM Users WHERE email = ? AND username = ?";
           $stmt = $this->conn->prepare($query);
           $stmt->execute([$email, $username]);
           $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) 
            {
                $storePW = $user['password'];
                // $password_hash = password_hash($password);
                if ( password_verify($password, $storePW)
                )
                {
                    return $user; 
                } else {
                    return null; 
                }
            } else 
            {
                return null; 
            }
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage();
        }
   
    
    }
    public function CreateData()
    {
        try{
            $query = "INSERT INTO Users (username, email, password) VALUES (:username,:email,:password)";
            $stmt = $this->conn->prepare($query);
            $password =  $this->data->password;
            $hash_passwords = password_hash($password,PASSWORD_DEFAULT);
            $result = $stmt->execute([
             ':username' => $this->data->username,
             ':email' => $this->data->email,
             ':password' => $hash_passwords,
            ]);
            if ($result) 
            {
            echo json_encode(['message' => 'Data inserted successfully', "status" => 201]);
            }   
            else
            {
            echo json_encode(['message' => 'Error inserting data',"status" => 404]);
            }
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        }
    }

    public function updateUser($id ){
        try{
            $query = "UPDATE Users SET username = :username, email = :email, password = :password WHERE user_id = :id";
            $stmt = $this->conn->prepare($query);
            $password = $this->data->password;
            $hash_passwords = password_hash($password,PASSWORD_DEFAULT);
            $result = $stmt->execute([
                ':username' => $this->data->username,
                ':email' => $this->data->email,
                ':password' => $hash_passwords,
                ':id' => $id
            ]);
            if ($result && $stmt->rowCount() > 0) {
                echo json_encode(['message' => 'Data updated successfully',"status" => 200]);
            } else {
                echo json_encode(['message' => 'Error updating data', "status"=> 404]);
            }
        }
        catch(Exception $e)
       {
        echo $e->getMessage();
        }
    }
public function indexUser($id){
    try{
        $query = "SELECT * FROM Users WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
    catch(Exception $e)
    {
            echo "Error: " . $e->getMessage();
    }
}
public function deleteUser($id){
    try{
        $query = "DELETE FROM Users WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$id]);
        if ($result  && $stmt->rowCount() > 0){
            echo json_encode(['message' => 'Data deleted successfully',"status" => 200]);
        } else {
            echo json_encode(['message' => 'Error deleting data , ID not found' , "status" => 404]);
        }
    }
    catch(Exception $e)
    {
            echo "Error: " . $e->getMessage();
    }
}
}


?>