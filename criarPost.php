<?php
try {
    require './db.php';
    header('Content-Type: application/json');

    $json = json_decode(file_get_contents('php://input'), true);

    if (isset($json['idObjeto']) && isset($json['idUsuario'])) {
        $idObjeto = $json['idObjeto'];
        $idUser = $json['idUsuario'];

        $sql = 'INSERT INTO post (idObjeto, idUsuario) VALUES (?, ?)';
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(1, $idObjeto);
        $stmt->bindParam(2, $idUser);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => true,
                'message' => 'Post realizado com sucesso'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'aaaaaaaaa.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Dados inválidos.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => 'Erro: ' . $e->getMessage()
    ]);
}

?>