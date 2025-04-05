<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
// echo "hello";
require "../Backends/database/db.php";

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$currentMethods = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode("/", trim($uri, "/"));
// print_r ($uri_parts);
$baseRoute = $uri_parts[0] ?? null;
$id = isset($uri_parts[1]) ? $uri_parts [1] : null;
$ID = isset($uri_parts[2]) ?  $uri_parts [2] : null;
// echo $id;
$routes = 
[
   'User' =>
   [
   'POST' => 
   [
    'login' => $ID ? './controllers/User/UserLoginController.php' : null,
    'register' => './controllers/User/UserRegisterController.php',
   ],
   'GET' =>  $id ? './controllers/User/IndexUserControlle.php' : './controllers/User/GetUserController.php',
   'PUT'  => './controllers/User/UpdateUserController.php',
   'DELETE' => './controllers/User/DeleteUserController.php',
],

   'Project' =>
   [
   "GET"  => $id ? "./controllers/Project/ShowByIdController.php" : "./controllers/Project/IndexController.php",
   "POST" => "./controllers/Project/StoreProjectController.php",
   "PUT" => $id ? "./controllers/Project/UpdateController.php" : null,
   "DELETE" => $id ? "./controllers/Project/DeleteController.php" : null,
   ] ,

   "Task" =>
   [
   "GET"  => $id ? "./controllers/Tasks/getByidController.php" : "./controllers/Tasks/indexController.php",
   "POST" => "./controllers/Tasks/StoreController.php",
   "PUT" => $id ? "./controllers/Tasks/UpdataController.php" : null,
   "DELETE" => $id ? "./controllers/Tasks/deleteController.php" : null,
   
   ]
];


if(isset($routes[$baseRoute]))
//check is that route that web have inlcude in $routes or not
{
    if(isset($routes[$baseRoute][$currentMethods]))
    //check is is have that method in the routes or not
    {
     if($currentMethods === "POST" && isset($uri_parts[1]))
    //  if it have check the method if is = post and 2d element have in there
     {
        $action = $uri_parts[1];
        // set action of that login or register
        if(isset($routes[$baseRoute][$currentMethods][$action]))
        {
        //if that user/post/login or register have in that or not 
        require $routes[$baseRoute][$currentMethods][$action];
        }
        else
        {
            echo json_encode(['error' => 'Action not found']);
        }
        
     }
     else
     {
        require $routes[$baseRoute][$currentMethods];
     }
    }
    else
    {
    echo json_encode(['error' => 'Method not allowed']);
    }
}

else
{
    echo json_encode(['error' => '404 Not Found']);
}