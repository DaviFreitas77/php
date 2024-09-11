<?php
require './db.php';

header('Content-Type: application/json');

$statusAtivoId = 3;

$sql = 'SELECT 
    post.idPost,
    objeto.idObjeto,
    objeto.images,
    objeto.descObjeto,
    objeto.dataRegistro,
    tbstatus.nomeStatus,
    tbsubcategoria.descSubCategoria ,
     tbcategoria.descCategoria ,
     tbcor.descCor,
     tblocal.descLocal,
     tbtamanho.descTamanho,
     tbmarca.descMarca,
     tbandar.descAndar,
     users.imagem,
      users.nome
FROM 
    post
INNER JOIN 
    objeto ON post.idObjeto = objeto.idObjeto
INNER JOIN 
    users ON post.idUsuario = users.id
INNER JOIN 
    tbstatus ON post.statusPost = tbstatus.idStatus
INNER JOIN 
    tbsubcategoria ON objeto.nomeObjeto = tbsubcategoria.idSubCategoria
    INNER JOIN
    tbcategoria ON objeto.categoriaObjeto = tbcategoria.idCategoria
  INNER JOIN
    tbcor ON objeto.corObjeto = tbcor.idCor
   	INNER JOIN
     tblocal ON objeto.localidadeObjeto = tblocal.idLocal
	INNER JOIN 
    tbtamanho on objeto.tamanhoObjeto = tbtamanho.idTamanho
    INNER JOIN 
     tbmarca on objeto.marcaObjeto = tbmarca.idMarca
     INNER JOIN
     tbandar on objeto.andar = tbandar.idAndar
     where post.statusPost = :statusAtivo;
 ';

try {

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':statusAtivo', $statusAtivoId, PDO::PARAM_INT); 
    $stmt->execute();


    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($users);
} catch (PDOException $e) {

    echo json_encode(['error' => 'Erro ao consultar o banco de dados: ' . $e->getMessage()]);
    http_response_code(500);
}
