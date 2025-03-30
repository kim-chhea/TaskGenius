<?php
$host= "localhost";
$username = "root";
$pass = "";
$dbName = "TaskGenuis";
$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
try{
    $conn = new PDO($dsn , $username , $pass);
}
catch(Exception $e)
{
    echo "Connection error: " . $e->getMessage();
}
?>