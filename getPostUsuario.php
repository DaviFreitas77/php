<?php
require './db.php';

header('Content-Type:application/json');

$usuario = $_GET['id'] ?? null;
$status = 3;
$sql = "SELECT post.*, 
       objeto.images, 
       tbsubcategoria.descSubCategoria, 
       tbmarca.descMarca, 
       tbcor.descCor, 
       tbandar.descAndar, 
       tblocal.descLocal, 
       objeto.dataRegistro,
       tbcaracteristicas.fkCaracterisca,
       tbcapacidadependrive.descCapacidade


FROM post
INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
INNER JOIN tbsubcategoria ON objeto.nomeObjeto = tbsubcategoria.idSubCategoria 
INNER JOIN tbmarca ON objeto.marcaObjeto = tbmarca.idMarca
INNER JOIN tbcor ON objeto.corObjeto = tbcor.idCor
INNER JOIN tbandar ON objeto.andar = tbandar.idAndar
INNER JOIN tblocal ON objeto.localidadeObjeto = tblocal.idLocal
INNER JOIN tbcaracteristicas ON objeto.caractAdicional = tbcaracteristicas.idCaractestica
INNER JOIN tbcapacidadependrive ON tbcaracteristicas.fkCaracterisca = tbcapacidadependrive.idCapacidade
WHERE post.statusPost = $status
  AND post.idUsuario = $usuario
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
