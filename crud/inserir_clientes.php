<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereço']; 
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    
    $sql = "INSERT INTO users (nome, cpf, endereço, telefone, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    
    if ($stmt) {
        
        $stmt->bind_param("sssss", $nome, $cpf, $endereco, $telefone, $email);

        
        if ($stmt->execute()) {
            
            header("Location: index.php");
            exit(); 
        } else {
            echo "Erro ao cadastrar cliente: " . $stmt->error;
        }
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo "Requisição inválida.";
}
?>
