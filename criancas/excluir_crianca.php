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

// Verifica se o ID foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepara e executa a consulta para deletar a criança
    $sql = "DELETE FROM criancas WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Criança excluída com sucesso.";
    } else {
        echo "Erro ao excluir criança: " . $conn->error;
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();

// Redireciona de volta para a página de visualização
header("Location: visualizar_criancas.php");
exit;
?>
