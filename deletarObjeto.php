<?php
require './db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: DELETE');

$id = $GET['id'] ?? '';

if($id){
    $sql = 'DELETE from objeto Where id = ?';
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1,$id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Objeto excluído com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao excluir objeto']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
}


?>