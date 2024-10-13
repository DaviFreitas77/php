<?php

require './db.php';

header('Content-Type: application/json');

$sql = 'select tbtipodenuncia.tipoDenunicia, users.nome,users.imagem, post.idPost from tbdenuncia
INNER JOIN tbtipodenuncia ON tbtipodenuncia.idTipoDenuncia =  tbdenuncia.idDescDenuncia
INNER JOIN users ON users.id = tbdenuncia.idUsuario
INNER JOIN post ON post.idPost = tbdenuncia.idPost';

try {
    $stmt = $conexao->prepare($sql); 
    $stmt->execute();
    
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results); 
} catch (PDOException $e) {
    echo json_encode([
        'message' => 'Não foi possível: ' . $e->getMessage() 
    ]);
}

?>