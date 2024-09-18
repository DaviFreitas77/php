<?php
require './db.php';


header('Content-Type: application/json');


$json = json_decode(file_get_contents('php://input'), true);

if (isset($json['texto']) && isset($json['remetente']) && isset($json['destinatario'])) {
    $mensagem = $json['texto'];
    $remetente = $json['remetente'];
    $destinatario = $json['destinatario'];


    $sql = 'INSERT INTO messages(sender_id, recipient_id, mensagem, created_at) VALUES (?, ?, ?, NOW())';

    
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $remetente);
    $stmt->bindParam(2, $destinatario);
    $stmt->bindParam(3, $mensagem);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Mensagem enviada com sucesso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao enviar a mensagem."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Preencha todos os campos."]);
}
?>