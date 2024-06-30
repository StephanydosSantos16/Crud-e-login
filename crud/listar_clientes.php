<?php
include 'conexao.php';


$sql = "SELECT * FROM users";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<h2>Clientes Cadastrados</h2>";
    echo "<ul>";
    
    while($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<strong>ID:</strong> " . $row['id'] . "<br>";
        echo "<strong>Nome:</strong> " . $row['nome'] . "<br>";
        echo "<strong>CPF:</strong> " . $row['cpf'] . "<br>";
        echo "<strong>Endereço:</strong> " . $row['endereço'] . "<br>";
        echo "<strong>Telefone:</strong> " . $row['telefone'] . "<br>";
        echo "<strong>Email:</strong> " . $row['email'] . "<br>";
        
        echo "<a href='editar_clientes.php?id=" . $row['id'] . "'>Editar</a> | ";
        echo "<a href='excluir_clientes.php?id=" . $row['id'] . "'>Excluir</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "0 resultados";
}

$conn->close();
?>
