<?php
require 'database/datab.php';
require './API/enviar_email_ativacao.php';

ob_start();

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$response = [];

if (!empty($email) && !empty($password)) {
    
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $response['status'] = 'error';
        $response['message'] = 'Email já registrado';
    } else {
        
        $senhacripto = password_hash($password, PASSWORD_DEFAULT);


        $tokenAtivacao = bin2hex(random_bytes(16));

        $stmt = $pdo->prepare("INSERT INTO usuarios (email, password, token_ativacao, ativado) VALUES (?, ?, ?, FALSE)");

        if ($stmt->execute([$email, $senhacripto, $tokenAtivacao])) {
            if (enviarEmailAtivacao($email, $tokenAtivacao)) {
                $response['status'] = 'success';
                $response['message'] = 'Registrado com sucesso. Verifique seu email para ativar sua conta.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Erro ao enviar email de ativação.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao registrar';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Falta email ou senha';
}

ob_end_clean();
echo json_encode($response);
?>
