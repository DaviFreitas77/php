<?php

require './db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$json = json_decode(file_get_contents('php://input'));


$nome = $json->nome ?? '';
$email = $json->email ?? '';
$senha = $json->senha ?? '';
$numero = $json->numero ?? '';
$dataNascimento = $json->dataNascimento ?? '';
$imagem = $json-> imagem ?? '';
$createdAt = date('Y-m-d H:i:s');;
$updatedAt = $createdAt;


if (empty($nome) || empty($email) || empty($senha) || empty($numero) || empty($dataNascimento)) {
    echo json_encode(['message' => 'Todos os campos devem ser preenchidos']);
    exit;
}


$sqlCheck = 'SELECT COUNT(*) FROM users WHERE email = :email';
$stmt = $conexao->prepare($sqlCheck);
$stmt->bindParam(':email', $email);
$stmt->execute();

$count = $stmt->fetchColumn();
if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
    exit;
}


$hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

$sql = 'INSERT INTO users(nome,email,senha,numeroCelular,dataNascimento,imagem,createdAt,updatedAt)VALUES(?,?,?,?,?,?,?,?)';

$stmt = $conexao->prepare($sql);
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $email);
$stmt->bindParam(3, $hashed_senha);
$stmt->bindParam(4, $numero);
$stmt->bindParam(5, $dataNascimento);
$stmt->bindParam(6, $imagem);
$stmt->bindParam(7, $createdAt);
$stmt->bindParam(8, $updatedAt);


if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Usuário registrado com sucesso."]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao registrar usuário."]);
}
