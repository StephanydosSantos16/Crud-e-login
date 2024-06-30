<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Clientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Clientes</h1>

        
        <div>
            <a href="login.php" class="login-link">Já possui cadastro? Faça login</a>
        </div>

        
        <div class="form-container">
            <h2>Adicionar Cliente</h2>
            <form id="formCliente" action="inserir_clientes.php" method="POST">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="cpf" placeholder="CPF" oninput="formatarCPF(this)" required>
                <input type="text" name="endereço" placeholder="Endereço" required>
                <input type="tel" name="telefone" placeholder="Telefone" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        
        <div class="clientes-lista">
            <h2>Clientes Cadastrados</h2>
            <ul id="listaClientes">
                <?php
                include 'conexao.php';
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<li id='cliente_" . $row["id"] . "'>" . $row["nome"]. " - " . $row["cpf"]. " - " . $row["endereço"]. " - " . $row["telefone"]. " - " . $row["email"]. "
                        <button onclick='editarCliente(" . $row["id"] . ")'>Editar</button>
                        <button onclick='excluirCliente(" . $row["id"] . ")'>Excluir</button>
                        </li>";
                    }
                } else {
                    echo "0 resultados";
                }
                $conn->close();
                ?>
            </ul>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function editarCliente(id) {
            fetch(`editar_clientes.php?id=${id}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('formCliente').innerHTML = data;

                    
                    document.getElementById('formCliente').setAttribute('action', `editar_clientes.php?id=${id}`);

                    
                    document.querySelector("button[type=submit]").innerText = "Atualizar";
                })
                .catch(error => console.error('Erro ao carregar formulário de edição:', error));
        }

        function excluirCliente(id) {
            if (confirm('Tem certeza que deseja excluir este cliente?')) {
                fetch("excluir_cliente.php?id=" + id, {
                    method: "GET"
                })
                .then(response => {
                    if (response.ok) {
                        carregarClientes(); 
                    } else {
                        throw new Error('Erro ao excluir cliente.');
                    }
                })
                .catch(error => console.error(error));
            }
        }
    </script>
</body>
</html>
