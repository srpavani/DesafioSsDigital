<?php

session_start();

require 'database/datab.php';

$response = [
    'logado' => false,
    'message' => ''
];


if (isset($_SESSION['user_id'])) {
    $response['logado'] = true;
    $response['message'] = 'sessao ativa.';
    echo json_encode($response);
    exit();
}


$email = $_POST['email'] ?? '';  
$password = $_POST['password'] ?? '';

if (!empty($email) && !empty($password)) {
    $stmt = $pdo->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $response['logado'] = true;
        $response['message'] = 'logado com sucesso';
    } else {
        $response['message'] = 'email ou senha incorretos';
    }
} else {
    $response['message'] = 'falta email ou senha';
}

echo json_encode($response);
?>
