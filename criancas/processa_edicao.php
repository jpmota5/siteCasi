<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coleta os dados do formulário
$id = $_POST['id'] ?? '';
$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$responsavel = $_POST['responsavel'] ?? '';
$contato1 = $_POST['contato1'] ?? '';
$contato2 = $_POST['contato2'] ?? '';
$turno = $_POST['turno'] ?? '';
$dia = $_POST['dia'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';

// Prepara a consulta SQL para atualização
$sql = "UPDATE criancas SET nome=?, endereco=?, responsavel=?, contato1=?, contato2=?, turno=?, dia=?, data_nascimento=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $nome, $endereco, $responsavel, $contato1, $contato2, $turno, $dia, $data_nascimento, $id);

$mensagem = "";
if ($stmt->execute()) {
    $mensagem = "Dados atualizados com sucesso!";
} else {
    $mensagem = "Erro: " . $stmt->error;
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Dados</title>
    <style>
        /* Estilos para o modal */
        .modal {
            display: none; /* Escondido por padrão */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo escurecido */
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
            border-radius: 10px;
        }
        .close-btn {
            background-color: #008000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .close-btn:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>

<!-- Estrutura do Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <p id="modal-message"><?php echo $mensagem; ?></p>
        <button class="close-btn" onclick="closeModal()">Fechar</button>
    </div>
</div>

<script>
    // Função para exibir o modal
    function showModal() {
        document.getElementById('myModal').style.display = 'flex';
    }

    // Função para fechar o modal
    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
        window.location.href = "visualizar_criancas.php"; // Redireciona após fechar o modal
    }

    // Exibe o modal automaticamente após o carregamento da página
    window.onload = function() {
        showModal();
    }
</script>

</body>
</html>
