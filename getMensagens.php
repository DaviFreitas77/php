<?php
require './db.php'; 


header('Content-Type: application/json');


$remetente = isset($_GET['remetente']) ? $_GET['remetente'] : null;
$destinatario = isset($_GET['destinatario']) ? $_GET['destinatario'] : null;

if ($remetente && $destinatario) {
   
    $sql = 'SELECT messages.id AS message_id, 
       messages.mensagem, 
       messages.created_at, 
       users.id AS sender_id, 
       users.nome AS sender_nome
FROM messages
JOIN users ON messages.sender_id = users.id
WHERE (messages.sender_id = ? AND messages.recipient_id = ?)
   OR (messages.sender_id = ? AND messages.recipient_id = ?)
ORDER BY messages.created_at DESC;';

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1, $remetente);
    $stmt->bindParam(2, $destinatario);
    $stmt->bindParam(3, $destinatario);
    $stmt->bindParam(4, $remetente);

    if ($stmt->execute()) {
        $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Retornando mensagens em um formato que o GiftedChat espera
        $response = array_map(function($msg) {
            return [
                '_id' => $msg['message_id'],
                'text' => $msg['mensagem'],
                'createdAt' => $msg['created_at'], 
                'user' => [
                    '_id' => $msg['sender_id'], 
                    'name' => $msg['sender_nome'], 
                ],
            ];
        }, $mensagens);

        echo json_encode($response);
    } else {
        echo json_encode(["status" => "error", "message" => "Falha ao buscar mensagens."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Parâmetros inválidos."]);
}
?>