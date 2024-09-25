<?php

session_start();
session_unset();
session_destroy();


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); 
header('Content-Type: application/json');

$response = [
    'success' => true,
    'message' => 'Logout efetuado com sucesso'
];

echo json_encode($response);
?>