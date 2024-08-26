<?php
require './db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


$input = file_get_contents('php://input');


$json = json_decode($input, true);

if(json_last_error() === JSON_ERROR_NONE){

    $category = $json['category'] ?? '';
    $item = $json['item'] ?? '';
    $tamanho = $json['tamanho'] ?? '';
    $andar = $json['livingroom'] ?? '';
    $local = $json['local'] ?? '';
    $desc = $json ['desc'];
    $cor = $json['cor'] ?? '';
    $images = json_encode($json['images']);
    $idUser = $json['idUser'];

    $sql = 'INSERT INTO objeto (categoriaObjeto, nomeObjeto, tamanhoObjeto, localidadeObjeto, andar, corObjeto, images, usuario, descObjeto, dataRegistro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(1,$category);
    $stmt->bindParam(2,$item);
    $stmt->bindParam(3,$tamanho).
    $stmt->bindParam(4,$andar);
    $stmt->bindParam(5,$local);
    $stmt->bindParam(6,$cor);
    $stmt->bindParam(7,$images);
    $stmt->bindParam(8,$idUser);
    $stmt->bindParam(9,$desc);
 


    if ($stmt->execute()){

      $newObjectId = $conexao->lastInsertId();
      $dataRegistro = date('d/m/Y');
      echo json_encode([
        'success'=> true, 
        'message'=>'Objeto Postado',
        'item' => $json['item'],
        'tamanho'=> $json['tamanho'],
        'category' => $json['category'],
        'cor' => $json['cor'],
        'imagem'=>$json['images'],
        'livingroom'=> $json['livingroom'],
        'local'=> $json['local'],
        'desc' =>$json ['desc'],
        'dataRegistro' => $dataRegistro ,
        
        'id' => $newObjectId,
        'idUser'=> $json ['idUser']

        
 
        

      ]);
    }else{
        echo json_encode(['success' => false,'message' => 'Objeto não postado']);
    }



}

?>
