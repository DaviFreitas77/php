<?php
    require './db.php';

    $sql = 'SELECT * FROM tbandar';

    try{
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $andar = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($andar);
    }catch(PDOException $e){

        json_encode(['error'=> 'não foi possivel retornar as cores'. $e->getMessage()]);
    }


?>