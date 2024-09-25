<?php
session_start();


header("Access-Control-Allow-Origin: http://localhost:3000"); //colocar seu ip 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");  
header('Content-Type: application/json'); 


$response = [
    'logado' => false,
    'session_time' => 0,
    'session_start_time' => 0,  
    'message' => 'Nenhuma sessão ativa'
];


if (isset($_SESSION['user_id']) && isset($_SESSION['inicioSessao'])) {
    $response['logado'] = true;
    $response['session_start_time'] = $_SESSION['inicioSessao']; 
    $response['session_time'] = time() - $_SESSION['inicioSessao']; 
    $response['message'] = 'Sessão ativa';
}

echo json_encode($response);
?>
