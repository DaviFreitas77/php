<?php
    require './db.php';

    header("Content-Type: application/json");

    $data = json_decode(file_get_contents('php://input'));

    $email = $data->email ?? '';
    $senha = $data->senha ?? '';

    $query = 'SELECT * FROM users WHERE email = :email LIMIT 1';
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user && password_verify($senha, $user['senha'])){
        echo json_encode([
            'success' => true,
            'nome' => $user['nome'], 
            'email' => $user ['email'],
            'numeroCelular' => $user['numeroCelular'],
            'imagem' => $user['imagem'],
            'dataNascimento' => $user['dataNascimento'],
            'id' => $user['id'],
            'message' => 'Login autorizado'
        ]);
    }else{
        echo json_encode(["success" => false, "message" => "E-mail ou senha incorretos."]);
    }
?>