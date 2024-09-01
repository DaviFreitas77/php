<?php
require './db.php'; 

header('Content-Type: application/json'); 


$sql = 'SELECT  idPost,objeto.idObjeto,idPost,nomeObjeto,categoriaObjeto,tamanhoObjeto,localidadeObjeto,andar,corObjeto,images,nome,imagem,descObjeto,dataRegistro,caracteristicasAdicionais from post INNER JOIN objeto on post.idObjeto = objeto.idObjeto
INNER JOIN 
    users ON post.idUsuario = users.id'; 

try {
   
    $stmt = $conexao->prepare($sql);
    $stmt->execute();


    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    echo json_encode($users);
} catch (PDOException $e) {

    echo json_encode(['error' => 'Erro ao consultar o banco de dados: ' . $e->getMessage()]);
    http_response_code(500);
}
