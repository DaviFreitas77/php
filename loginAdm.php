<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require './db.php'; 


$data = json_decode(file_get_contents('php://input'));

$token = $data->code ?? '';


$sql = 'SELECT * FROM adm WHERE token = :code LIMIT 1';

$stmt = $conexao->prepare($sql); 
$stmt->bindParam(':code', $token);
$stmt->execute();


$adm = $stmt->fetch(PDO::FETCH_ASSOC);

if ($adm) {
   
    echo json_encode([
        'status' => true,
        'message' => 'Login efetuado',
        'token' => $adm['token'],
        'email' => $adm['email'],
        'nome'=>$adm['nome']
    ]);
} else {

    echo json_encode([
        'status' => false,
        'message' => 'Código inválido'
    ]);
}
?>