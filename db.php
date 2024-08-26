<?php

$host = 'localhost';
$dbName = 'db_acheAqui';
$dbUser = 'root';
$dbPassword = '';

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbName;", $dbUser, $dbPassword);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    return $conexao;
} catch (PDOException $e) {
    echo json_encode(['message' => 'Erro ao conectar com o banco de dados', 'error' => $e->getMessage()]);
    http_response_code(500);
    exit;
}
?>
