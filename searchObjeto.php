<?php
require './db.php';


$json = json_decode(file_get_contents('php://input'), true);


$item = $json['item'] ?? null;
$tamanho = $json['tamanho'] ?? null;
$cor = $json['cor'] ?? null;


$sql = 'SELECT idPost, objeto.idObjeto, idPost, nomeObjeto, categoriaObjeto, tamanhoObjeto, localidadeObjeto, andar, corObjeto, images, nome, imagem, descObjeto, dataRegistro, caracteristicasAdicionais 
        FROM post 
        INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
        INNER JOIN users ON post.idUsuario = users.id 
        WHERE 1=1'; 

$params = [];

if ($item) {
    $sql .= ' AND nomeObjeto = ?';
    $params[] = $item;
}

if ($tamanho) {
    $sql .= ' AND tamanhoObjeto = ?';
    $params[] = $tamanho;
}

if ($cor) {
    $sql .= ' AND corObjeto = ?';
    $params[] = $cor;
}


$stmt = $conexao->prepare($sql);

if ($stmt) {
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
 
    if ($results) {
        echo json_encode($results);
    } else {
        echo json_encode(['message' => 'Nenhum objeto encontrado.']);
    }
} else {

    echo json_encode(['error' => 'Erro ao preparar a consulta.']);
}
?>