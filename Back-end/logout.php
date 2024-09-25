<?php
session_start();
session_unset();
session_destroy();

$response = [
    'logado' => false,
    'message' => 'Você foi deslogado com sucesso.'
];

echo json_encode($response);