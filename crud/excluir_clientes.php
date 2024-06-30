<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id = ?"; 
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        if ($stmt->execute()) {
            echo "Cliente excluído com sucesso.";
        } else {
            echo "Erro ao excluir cliente: " . $stmt->error;
        }
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID do cliente não fornecido ou requisição inválida.";
}

$conn->close();
?>
