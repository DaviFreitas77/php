<?php
require './db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$data = json_decode(file_get_contents("php://input"));


if (!isset($data->id)) {
    echo json_encode(["status" => "error", "message" => "ID não foi fornecido."]);
    exit;
}

if (isset($data->nome)) {
    $id = $data->id;
    $nome = $data->nome;

    $sql = 'UPDATE users SET nome=? WHERE id=?';
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Nome atualizado com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao atualizar o nome."]);
    }
}


if (isset($data->numeroCelular)) {
    $id = $data->id;
    $numeroCelular = $data->numeroCelular;

    $sql = "UPDATE users SET numeroCelular=? WHERE id=?";
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(1, $numeroCelular);
    $stmt->bindParam(2, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Número de celular atualizado com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Falha ao atualizar número de celular']);
    }

}


if (isset($data->imagem)) {
    $id = $data->id;
    $imagem = $data->imagem;

    $sql = "UPDATE users SET imagem=? WHERE id=?";
    $stmt = $conexao->prepare($sql);
    
    $stmt->bindParam(1, $imagem);
    $stmt->bindParam(2, $id);

    if ($stmt->execute()) {
        $successMessages[] = "Imagens atualizadas com sucesso.";
    } else {
        $errorMessages[] = "Falha ao atualizar imagens.";
    }
}