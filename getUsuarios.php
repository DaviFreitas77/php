<?php
require './db.php';

header('Content-Type: Application/json');

$sql =  'SELECT id,nome,email  FROM users;';
try{        
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($usuarios);

}catch(PDOException $e){
    echo  json_encode(['error'=> 'não foi possivel retornar os usuarios'. $e->getMessage()]);
}



?>
