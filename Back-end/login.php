<?php

session_start();

require 'database/datab.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true); 

$email = $data['email'] ?? '';  
$password = $data['password'] ?? '';

$response = [
    'logado' => false,
    'message' => '',
    'user' => null
];

if (isset($_SESSION['user_id'])) {
    $response['logado'] = true;
    $response['message'] = 'sessao ativa.';
    $response['user'] = [
        'id' => $_SESSION['user_id']
    ];
    echo json_encode($response);
    exit();
}

if (!empty($email) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $response['logado'] = true;
        $response['message'] = 'logado com sucesso';
        $response['user'] = [
            'id' => $user['id']
        ];
    } else {
        $response['message'] = 'email ou senha incorretos';
    }
} else {
    $response['message'] = 'falta email/senha';
}

echo json_encode($response);
?>
