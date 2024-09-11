<?php
 require './db.php';

 $sql = 'SELECT * FROM tbcategoria';

 try{
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $categoria = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($categoria);
 }catch(PDOException $e){


    echo json_encode(['error' => 'Erro ao consultar o banco de dados: ' . $e->getMessage()]);
 }



?>