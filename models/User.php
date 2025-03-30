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
            echo json_encode(['message' => 'Data inserted successfully']);
            }   
            else
            {
            echo json_encode(['message' => 'Error inserting data']);
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
            $stmt = $this->conn->prepare($query ,[$id]);
            $result = $stmt->execute([
                ':username' => $this->data->username,
                ':email' => $this->data->email,
                ':password' => $this->data->password,
            ]);
            if ($result) {
                echo json_encode(['message' => 'Data updated successfully']);
            } else {
                echo json_encode(['message' => 'Error updating data']);
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
        if ($result) {
            echo json_encode(['message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['message' => 'Error deleting data']);
        }
    }
    catch(Exception $e)
    {
            echo "Error: " . $e->getMessage();
    }
}
}


?>