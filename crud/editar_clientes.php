<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $endereco = $row['endereço'];
        $telefone = $row['telefone'];
        $email = $row['email'];
    } else {
        echo "Cliente não encontrado.";
        exit();
    }
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]); 
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $endereco = $_POST["endereço"]; 
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $sql = "UPDATE users SET nome=?, cpf=?, endereço=?, telefone=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $cpf, $endereco, $telefone, $email, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar cliente: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Requisição inválida.";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>
        <form action="editar_clientes.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="text" name="nome" placeholder="Nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            <input type="text" name="cpf" placeholder="CPF" value="<?php echo htmlspecialchars($cpf); ?>" required>
            <input type="text" name="endereço" placeholder="Endereço" value="<?php echo htmlspecialchars($endereco); ?>" required>
            <input type="tel" name="telefone" placeholder="Telefone" value="<?php echo htmlspecialchars($telefone); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <button type="submit">Salvar Alterações</button> 
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
