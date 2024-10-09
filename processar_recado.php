<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém os dados do formulário
$titulo = $_POST['titulo'];
$conteudo = $_POST['conteudo'];

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO recados (titulo, mensagem) VALUES (?, ?)";

// Prepara e executa a consulta com proteção contra SQL Injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $titulo, $conteudo);

if ($stmt->execute()) {
    // Script JavaScript para exibir o popup e redirecionar
    echo "<script>
        alert('Novo recado adicionado com sucesso!');
        window.location.href = 'mural.php';
    </script>";
} else {
    // Script JavaScript para exibir o popup de erro
    echo "<script>
        alert('Erro ao adicionar recado: " . $stmt->error . "');
        window.location.href = 'mural.php';
    </script>";
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
