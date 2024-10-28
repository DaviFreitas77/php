<?php
require './db.php';

// Obtém os dados JSON da requisição
$json = json_decode(file_get_contents('php://input'), true);


$item = $json['item'] ?? null;
$tamanho = $json['tamanho'] ?? null;
$cor = $json['cor'] ?? null;
$marca = $json['marca'] ?? null;
$caracteristica = $json['caracteristica'] ?? null;


$sql = 'SELECT idPost, objeto.idObjeto, nomeObjeto, categoriaObjeto, localidadeObjeto, images, nome, imagem, descObjeto, dataRegistro, descMarca, descTamanho, descAndar, descLocal, descCor, descSubCategoria, descCategoria, users.id,tbcaracteristicas.fkCaracterisca, post.statusPost,tbcapacidadependrive.descCapacidade
        FROM post
        INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
        INNER JOIN users ON post.idUsuario = users.id
        INNER JOIN tbmarca ON objeto.marcaObjeto = tbmarca.idMarca
        INNER JOIN tbtamanho ON objeto.tamanhoObjeto = tbtamanho.idTamanho
        INNER JOIN tbandar ON objeto.andar = tbandar.idAndar
        INNER JOIN tblocal ON objeto.localidadeObjeto = tblocal.idLocal
        INNER JOIN tbcor ON objeto.corObjeto = tbcor.idCor
        INNER JOIN tbsubcategoria ON objeto.nomeObjeto = tbsubcategoria.idSubCategoria
        INNER JOIN tbcategoria ON objeto.categoriaObjeto = tbcategoria.idCategoria
        INNER JOIN tbcaracteristicas ON objeto.caractAdicional = tbcaracteristicas.idCaractestica
        INNER JOIN tbcapacidadependrive on tbcaracteristicas.fkCaracterisca = tbcapacidadependrive.idCapacidade
        WHERE post.statusPost = :statusAtivo'; 

$params = ['statusAtivo' => 3]; 


if ($item) {
    $sql .= ' AND nomeObjeto = :item';
    $params['item'] = $item;
}

if ($tamanho) {
    $sql .= ' AND tamanhoObjeto = :tamanho';
    $params['tamanho'] = $tamanho;
}

if ($cor) {
    $sql .= ' AND corObjeto = :cor';
    $params['cor'] = $cor;
}

if ($marca) {
    $sql .= ' AND marcaObjeto = :marca';
    $params['marca'] = $marca;
}

if ($caracteristica) {
    $sql .= ' AND objeto.caractAdicional = :caracteristica';
    $params['caracteristica'] = $caracteristica;
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
