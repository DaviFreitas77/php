<?php
    require './db.php';

    $sql = 'select * from tbsubcategoria';

    try{
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $subCategoria = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($subCategoria);
    }catch(PDOException $e){
        echo json_encode (['error'=> 'não foi possivel trazer as subCategoria']);
    }


?>