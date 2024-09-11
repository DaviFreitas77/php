<?php
    require './db.php';

    $sql = 'SELECT * FROM tbtamanho';

    try{
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $tamanho = $stmt->fetchAll(PDO::FETCH_ASSOC);

       echo json_encode($tamanho);
    }catch(PDOException $e){

      echo  json_encode(['error'=> 'não foi possivel retornar os tamanhos'. $e->getMessage()]);
    }


?>