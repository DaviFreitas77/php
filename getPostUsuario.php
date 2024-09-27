<?php
require './db.php';

header('Content-Type:application/json');

$usuario = $_GET['id'] ?? null;

$sql = "SELECT post.*, objeto.images, tbsubcategoria.descSubCategoria, tbmarca.descMarca, tbcor.descCor, tbandar.descAndar, tblocal.descLocal
FROM post
INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
INNER JOIN tbsubcategoria ON objeto.nomeObjeto = tbsubcategoria.idSubCategoria 
INNER JOIN tbmarca on objeto.marcaObjeto = tbmarca.idMarca
INNER JOIN tbcor on objeto.corObjeto = tbcor.idCor
INNER JOIN tbandar on objeto.andar = tbandar.idAndar
INNER JOIN tblocal on objeto.localidadeObjeto = tblocal.idLocal
WHERE $usuario
";

$stmt = $conexao->prepare($sql);
if ($usuario) {
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
} else {
    echo json_encode([
        'message' => 'usuario invalidoa'
    ]);
}
