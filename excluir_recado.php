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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta SQL para excluir o recado
    $sql = "DELETE FROM recados WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Recado excluído com sucesso!');
            window.location.href = 'mural.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao excluir recado: " . $stmt->error . "');
            window.location.href = 'mural.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('ID do recado não especificado.');
        window.location.href = 'mural.php';
    </script>";
}

$conn->close();
?>
