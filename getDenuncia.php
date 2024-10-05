<?php
require './db.php';

header('Content-Type: application/json');

$sql = 'SELECT * FROM tbtipodenuncia';

try {
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    
    $denuncias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($denuncias); 
} catch (PDOException $e) {
    
    echo json_encode(['message' => 'error', 'error' => $e->getMessage()]);
}
?>