<?php
require './db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: PATCH'); 
header('Access-Control-Allow-Headers: Content-Type'); 

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $input = file_get_contents("php://input", true);
    $json = json_decode($input, true);
    $id = $json['id'] ?? '';
    $atuacao = $json['atuacao'] ?? ''; 


    if ($id) {
        if ($atuacao === 'ativar') {
            $statusDesativado = 3; 
        } else {
            $statusDesativado = 4; 
        }
        
        $sql = 'UPDATE post SET statusPost = ? WHERE idPost = ?'; 
        $stmt = $conexao->prepare($sql);
   
        $stmt->bindParam(1, $statusDesativado); 
        $stmt->bindParam(2, $id); 


        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Ação executada com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Falha ao executar ação']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição não permitido']);
}
?>