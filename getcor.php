<?php
    require './db.php';

    $sql = 'SELECT * FROM tbcor';

    try{
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $cores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($cores);
    }catch(PDOException $e){

        json_encode(['error'=> 'não foi possivel retornar as cores'. $e->getMessage()]);
    }


?>