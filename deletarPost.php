<?php
require './db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: DELETE'); 
header('Access-Control-Allow-Headers: Content-Type'); 


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = file_get_contents("php://input",true);
    $json = json_decode($input, true);
    $id = $json['id'] ?? '';

    if ($id) {
        $sql = 'DELETE FROM post WHERE idPost = ?';
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Objeto excluído com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Falha ao excluir objeto']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição não permitido']);
}
?>
