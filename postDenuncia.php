<?php
require './db.php'; 

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$idDenuncia = $input['idDenuncia'] ?? '';
$idUsuario = $input['idUsuario'] ?? ''; 
$idPost = $input['idPost'] ?? ''; 

$sql = 'INSERT INTO tbdenuncia(idUsuario,idPost,idDescDenuncia)VALUES(?,?,?)';
try{
    $stmt= $conexao->prepare($sql);

    $stmt->bindParam(1, $idUsuario);
    $stmt->bindParam(2,$idPost);
    $stmt->bindParam(3,$idDenuncia);
    if ($stmt->execute()) {
        echo json_encode([
            "message" => 'Denuncia realizada'
        ]);
    } else {
        echo json_encode([
            "message" => 'Denuncia não realizada'
        ]);
    }
}catch(PDOException $e){
    echo json_encode([
        "message" =>'Denuncia não realizada'
    ]);
}




?>