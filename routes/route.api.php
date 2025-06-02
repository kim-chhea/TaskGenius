<?php
require_once './middlewares/auth.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");

require "../Backends/database/db.php";
// if (authenticate()) {
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
   'user' =>
   [
   'POST' =>  
   [
    'login' =>  './controllers/User/UserLoginController.php' ,
    'register' => './controllers/User/UserRegisterController.php',
   ],
   'GET' =>  $id ? './controllers/User/IndexUserControlle.php' : './controllers/User/GetUserController.php',
   'PUT'  => './controllers/User/UpdateUserController.php',
   'DELETE' => './controllers/User/DeleteUserController.php',
],

   'projects' =>
   [
   "GET"  => $id ? "./controllers/Project/ShowByIdController.php" : "./controllers/Project/IndexController.php",
   "POST" => "./controllers/Project/StoreProjectController.php",
   "PUT" => $id ? "./controllers/Project/UpdateController.php" : null,
   "DELETE" => $id ? "./controllers/Project/DeleteController.php" : null,
   ] ,

   "tasks" =>
   [
   "GET"  => $id ? "./controllers/Tasks/getByidController.php" : "./controllers/Tasks/indexController.php",
   "POST" => "./controllers/Tasks/StoreController.php",
   "PUT" => $id ? "./controllers/Tasks/UpdataController.php" : null,
   "DELETE" => $id ? "./controllers/Tasks/deleteController.php" : null,
   ],
   "notes" => 
   [
     "GET" => $id ? "./controllers/note/ShowController.php" : "./controllers/note/indexController.php",
     "POST" => "./controllers/note/StoreController.php",
     "PUT" => $id ? "./controllers/note/UpdateController.php" : null,
     "DELETE" => $id ? "./controllers/note/DestroyController.php" : null,
   ],
   "suggestions" =>
   [
     "GET" => $id ? "./controllers/TaskSuggestion/ShowContoller.php" : "./controllers/TaskSuggestion/IndexController.php",
     "POST" => "./controllers/TaskSuggestion/StoreController.php",
     "PUT" => $id ? "./controllers/TaskSuggestion/UpdataController.php" : null,
     "DELETE" => $id ? "./controllers/TaskSuggestion/deleteController.php" : null 
   ],
   "profiles" =>
   [
      "GET" => $id ? "./controllers/Profiles/ShowCotroller.php"  : "./controllers/Profiles/IndexController.php",
      "POST" => "./controllers/Profiles/StoreController.php",
      "PUT" => $id ? "./controllers/Profiles/UpdateController.php"  : null,
      "DELETE" => $id ? "./controllers/Profiles/DeleteController.php"  : null,
   ],
   
   
   

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
            echo json_encode(['error' => 'Endpoint not found']);
        }
        
     }
     else
     { 
        if(authenticate())
        {
         echo json_encode(["message" => "Access granted to protected data."]);
         require $routes[$baseRoute][$currentMethods];
        }
        
     }
    }
    else
    {
    echo json_encode(['error' => 'Method not allowed']);
    }
}
// }


else
{
    echo json_encode(['error' => '404 Not Found']);
}