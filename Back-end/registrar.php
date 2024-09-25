<?php
require 'database/datab.php';

header("Access-Control-Allow-Origin: http://localhost:3000"); //colocar seu ip 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json'); 


$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$response = []; // iniciar array para a resposta em json

if (!empty($email) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        $response['status'] = 'error';
        $response['message'] = 'Email já registrado';
    } else {
       
        $senhacripto = password_hash($password, PASSWORD_DEFAULT); //passwordHash nativo do php, faz a criptografia
        $stmt = $pdo->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
        
        if ($stmt->execute([$email, $senhacripto])) {
            $response['status'] = 'success';
            $response['message'] = 'Registrado';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao registrar';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Falta email ou senha';
}

echo json_encode($response);    //retorna o json
?>
