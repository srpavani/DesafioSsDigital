<?php
require 'database/datab.php';


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$tokenAtivacao = $_GET['token'] ?? '';

$response = [
    'status' => 'error',
    'message' => 'Token inválido ou conta já ativada.'
];

if (!empty($tokenAtivacao)) {
    
    $stmt = $pdo->prepare("SELECT id, ativado FROM usuarios WHERE token_ativacao = ?");
    $stmt->execute([$tokenAtivacao]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        if ($usuario['ativado'] == false) {
        
            $stmt = $pdo->prepare("UPDATE usuarios SET ativado = TRUE, token_ativacao = NULL WHERE id = ?");
            if ($stmt->execute([$usuario['id']])) {
                $response['status'] = 'success';
                $response['message'] = 'Conta ativada com sucesso! Redirecionando para login...';
            } else {
                $response['message'] = 'Erro ao ativar a conta. Tente novamente.';
            }
        } else {
            $response['message'] = 'Sua conta já foi ativada anteriormente.';
        }
    } else {
        $response['message'] = 'Token inválido. Nenhuma conta associada a este token.';
    }
} else {
    $response['message'] = 'Token de ativação não fornecido.';
}

echo json_encode($response);
?>
