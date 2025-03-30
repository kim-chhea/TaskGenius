<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
require '../Backends/database/db.php';
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$currentMethods = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode("/", trim($uri, "/"));
// print_r ($uri_parts);
$baseRoute = $uri_parts[0] ?? null;
$id = isset($uri_parts[1]) ? $uri_parts [1] : null;
// echo $id;
$routes = 
[
   'User' =>
   [
   'POST' => './controllers/User/UserLoginController.php',
   'GET' =>  $id ? './controllers/User/IndexUserControlle.php' : './controllers/User/GetUserController.php',
   'PUT'  => './controllers/User/UpdateUserController.php',
   'DELETE' => './controllers/User/DeleteUserController.php',
   ]
];


if(isset($routes[$baseRoute]) && isset($routes[$baseRoute][$currentMethods]))
{
    require $routes[$baseRoute][$currentMethods];
   
}
else
{
    echo json_encode(['erro'=> '404 not found']);
}