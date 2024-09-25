<?php
require 'database/datab.php';


header('Content-Type: application/json'); //configura o Header para trabalhar com json


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
