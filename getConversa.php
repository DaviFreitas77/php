<?php
require './db.php'; 

header('Content-Type: application/json');

$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : null;

if ($usuario) {
    $sql = 'SELECT 
        users.id AS sender_id, 
        users.nome AS sender_nome, 
        users.imagem,
        MAX(messages.created_at) AS last_message_time,
        (SELECT mensagem 
         FROM messages 
         WHERE sender_id = users.id AND recipient_id = ? 
         ORDER BY created_at DESC 
         LIMIT 1) AS last_message
    FROM messages
    JOIN users ON messages.sender_id = users.id
    WHERE messages.recipient_id = ?
    GROUP BY users.id, users.nome, users.imagem
    ORDER BY last_message_time DESC;';

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $usuario, PDO::PARAM_INT); 
    $stmt->bindParam(2, $usuario, PDO::PARAM_INT);  

    if ($stmt->execute()) {
        $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($mensagens);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao buscar mensagens."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Parâmetros inválidos."]);
}
?>