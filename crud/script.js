document.addEventListener("DOMContentLoaded", function() {
    carregarClientes();

    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault();
        adicionarCliente();
    });
});

function formatarCPF(input) {
    let cpf = input.value.replace(/\D/g, '');
    if (cpf.length > 3) cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    if (cpf.length > 6) cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    if (cpf.length > 9) cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = cpf;
}

function carregarClientes() {
    fetch("listar_clientes.php")
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar lista de clientes. Código HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(clientes => {
            const listaClientes = document.getElementById("listaClientes");
            listaClientes.innerHTML = "";
            clientes.forEach(cliente => {
                const clienteItem = document.createElement("li");
                clienteItem.innerHTML = `
                    <span><strong>Nome:</strong> ${cliente.nome}</span><br>
                    <span><strong>CPF:</strong> ${cliente.cpf}</span><br>
                    <span><strong>Endereço:</strong> ${cliente.endereco}</span><br>
                    <span><strong>Telefone:</strong> ${cliente.telefone}</span><br>
                    <span><strong>Email:</strong> ${cliente.email}</span><br>
                    <button onclick="editarCliente(${cliente.id})">Editar</button>
                    <button onclick="excluirCliente(${cliente.id})">Excluir</button>
                `;
                listaClientes.appendChild(clienteItem);
            });
        })
        .catch(error => {
            console.error("Erro ao carregar clientes:", error.message);
            
        });
}

function adicionarCliente() {
    const formData = new FormData(document.querySelector("form"));
    fetch("inserir_clientes.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (response.ok) {
            document.querySelector("form").reset();
            carregarClientes();
        } else {
            throw new Error('Erro ao adicionar cliente. Código HTTP: ' + response.status);
        }
    })
    .catch(error => console.error("Erro ao adicionar cliente:", error.message));
}

function editarCliente(id) {
    fetch(`editar_cliente.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar formulário de edição. Código HTTP: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('formCliente').innerHTML = data;
            document.getElementById('formCliente').addEventListener('submit', function(event) {
                event.preventDefault();
                atualizarCliente(id);
            });
        })
        .catch(error => console.error('Erro ao carregar formulário de edição:', error.message));
}

function atualizarCliente(id) {
    const formData = new FormData(document.querySelector("#formCliente"));
    formData.append("id", id); 

    fetch("editar_cliente.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('formCliente').reset();
            carregarClientes();
        } else {
            throw new Error('Erro ao atualizar cliente. Código HTTP: ' + response.status);
        }
    })
    .catch(error => console.error("Erro ao atualizar cliente:", error.message));
}
function excluirCliente(id) {
    if (confirm("Tem certeza que deseja excluir este cliente?")) {
        fetch("excluir_cliente.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}`
        })
        .then(response => {
            if (response.ok) {
                carregarClientes();
            } else {
                throw new Error('Erro ao excluir cliente. Código HTTP: ' + response.status);
            }
        })
        .catch(error => console.error("Erro ao excluir cliente:", error.message));
    }
}



