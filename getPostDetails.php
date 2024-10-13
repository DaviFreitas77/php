<?php
require './db.php';

$idPost = $_GET['idPost'] ?? null;


$sql = '
SELECT 
    post.idPost,
    objeto.nomeObjeto,
    objeto.categoriaObjeto,
    objeto.tamanhoObjeto,
    objeto.localidadeObjeto,
    objeto.descObjeto,
    objeto.marcaObjeto,
    objeto.andar,
    objeto.corObjeto,
    objeto.images,
    objeto.usuario,
    objeto.dataRegistro,
    tbsubcategoria.descSubCategoria,
    tbandar.descAndar,
    tbmarca.descMarca,
    tbcor.descCor,
    tblocal.descLocal,
    tbcategoria.descCategoria
FROM post
INNER JOIN objeto ON post.idObjeto = objeto.idObjeto
INNER JOIN tbsubcategoria ON objeto.nomeObjeto = tbsubcategoria.idSubCategoria
INNER JOIN tbandar ON objeto.andar = tbandar.idAndar
INNER JOIN tbmarca ON objeto.marcaObjeto = tbmarca.idMarca
INNER JOIN tbcor ON objeto.corObjeto = tbcor.idCor
INNER JOIN tblocal ON objeto.localidadeObjeto = tblocal.idLocal
INNER JOIN tbcategoria ON objeto.categoriaObjeto = tbcategoria.idCategoria
WHERE post.idPost = :idPost';

try {
    $stmt = $conexao->prepare($sql);
    if ($idPost) {
        $stmt->bindParam(':idPost', $idPost, PDO::PARAM_INT); 
        $stmt->execute();
        $post = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    
        echo json_encode($post);
    } else {
        echo json_encode(['error' => 'ID do post não fornecido.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Não foi possível retornar o post: ' . $e->getMessage()]);
}
?>