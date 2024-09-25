<?php

require 'env.php'; 

loadEnv(__DIR__ . '/.env'); //funcao para conseguir usar .env

$host = getenv('DB_HOST');
$db = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$port = 5439;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$info = "pgsql:host=$host;port=$port;dbname=$db;options='--client_encoding=UTF8'";
try {
    $pdo = new PDO($info, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
