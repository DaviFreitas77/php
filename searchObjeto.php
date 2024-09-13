<?php
require './db.php';


$json = json_decode(file_get_contents('php://input'), true);


$item = $json['item'] ?? null;
$tamanho = $json['tamanho'] ?? null;
$cor = $json['cor'] ?? null;
$marca = $json['marca'] ?? null;


$sql = 'SELECT idPost, objeto.idObjeto, idPost, nomeObjeto, categoriaObjeto, localidadeObjeto, images, nome, imagem, descObjeto, dataRegistro, descMarca,descTamanho,descAndar,descLocal,descCor,descSubCategoria,descCategoria
FROM post 
INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
INNER JOIN users ON post.idUsuario = users.id
INNER JOIN 
    tbmarca ON objeto.marcaObjeto = tbmarca.idMarca
INNER JOIN tbtamanho on objeto.tamanhoObjeto = tbtamanho.idTamanho
INNER JOIN tbandar on objeto.andar = tbandar.idAndar
INNER JOIN tblocal on objeto.localidadeObjeto = tblocal.idLocal
INNER JOIN tbcor on objeto.corObjeto = tbcor.idCor
INNER JOIN tbsubcategoria on objeto.nomeObjeto = tbsubcategoria.idSubCategoria
inner JOIN tbcategoria on objeto.categoriaObjeto = tbcategoria.idCategoria
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

if ($marca) {
    $sql .= ' AND marcaObjeto = ?';
    $params[] = $marca;
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