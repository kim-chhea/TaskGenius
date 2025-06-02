<?php
require_once __DIR__ . '/../vendor/autoload.php';  // Ensure this is included

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function authenticate() {
    session_start();

    //  secret key for decoding JWT
    $key = "8120-jwt-taskgenius";  

    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        // Extract the JWT from the Authorization header
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $jwt = str_replace('Bearer ', '', $authHeader);

        try {
            // Decode the JWT (correct the decoding part by passing only key and algorithm)
              // Fixed issue
              $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            // Set the decoded user data in the request for further use
            $_SESSION['user'] = (array) $decoded;  // Example: Store user info in session
            return true;  // Proceed with the request
        } catch (Exception $e) {
            // Invalid or expired JWT
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized. " . $e->getMessage()]);
            return false;  // Stop the request
        }
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized. No token provided."]);
        return false;
    }
}
