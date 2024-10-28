<?php
require './db.php';

$item_id = $_GET['id'] ?? null;

$sql = 'SELECT tbcapacidadependrive.descCapacidade,tbcaracteristicas.idCaractestica
FROM tbcaracteristicas 

INNER JOIN tbcapacidadependrive on tbcaracteristicas.fkCaracterisca = tbcapacidadependrive.idCapacidade
WHERE tbcaracteristicas.fkItem = :fkItem'; 

try {
    $stmt = $conexao->prepare($sql);
    if ($item_id) {
        $stmt->bindParam(':fkItem', $item_id, PDO::PARAM_INT); 
        $stmt->execute();
        $caracteristicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($caracteristicas)) {
            echo json_encode($caracteristicas);
        } else {
            echo json_encode(['error' => 'Nenhuma característica encontrada para este item']);
        }
    } else {
        echo json_encode(['error' => 'Item ID não fornecido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Não foi possível retornar as características: ' . $e->getMessage()]);
}
?>
