<?php
   require './db.php';

   $item_id = $_GET['id'] ?? null; 
   $sql = 'SELECT * FROM tbMarca WHERE idSubCategoria = :idSubCategoria'; 
   
   try {
       $stmt = $conexao->prepare($sql);
       if ($item_id) {
           $stmt->bindParam(':idSubCategoria', $item_id, PDO::PARAM_INT);
           $stmt->execute();
           $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
           echo json_encode($marcas);
       } else {
           echo json_encode(['error' => 'Item ID não fornecido']);
       }
   } catch (PDOException $e) {
       echo json_encode(['error' => 'Não foi possível retornar as marcas: ' . $e->getMessage()]);
   }

?>