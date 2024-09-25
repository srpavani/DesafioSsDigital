<?php

session_start();


header("Access-Control-Allow-Origin: http://localhost:3000"); //colocar seu ip 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json'); 

require 'database/datab.php';


$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';  
$password = $data['password'] ?? '';

$response = [
    'logado' => false,
    'message' => '',
    'user' => null
];


if (!empty($email) && !empty($password)) {

    $stmt = $pdo->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    
    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $email;  
        $_SESSION['inicioSessao'] = time();  

        
        $response['logado'] = true;
        $response['message'] = 'Login efetuado com sucesso.';
        $response['user'] = [
            'id' => $user['id'],
            'email' => $email
        ];
    } else {
        
        $response['message'] = 'Email ou senha incorretos.';
    }
} else {
    
    $response['message'] = 'Falta email ou senha.';
}


echo json_encode($response);
?>
