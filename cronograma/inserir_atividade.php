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
$horario = $_POST['horario'] ?? '';
$segunda = $_POST['segunda'] ?? '';
$terca = $_POST['terca'] ?? '';
$quarta = $_POST['quarta'] ?? '';
$quinta = $_POST['quinta'] ?? '';
$sexta = $_POST['sexta'] ?? '';

// Prepara a consulta SQL para inserção
$sql = "INSERT INTO cronograma (horario, segunda, terca, quarta, quinta, sexta) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $horario, $segunda, $terca, $quarta, $quinta, $sexta);

if ($stmt->execute()) {
    echo "<script>alert('Dados inseridos com sucesso!'); window.location.href = 'visualizar_cronograma.php';</script>";
} else {
    echo "Erro: " . $stmt->error;
}

// Fecha a conexão
$conn->close();
?>
