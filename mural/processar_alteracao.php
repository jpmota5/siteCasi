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

if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['mensagem'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['mensagem'];

    // Prepara a consulta SQL para atualizar o recado
    $sql = "UPDATE recados SET titulo = ?, mensagem = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $titulo, $conteudo, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Recado atualizado com sucesso!');
            window.location.href = 'mural.php';
        </script>";
    } else {
        echo "<script>
            alert('Erro ao atualizar recado: " . $stmt->error . "');
            window.location.href = 'mural.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Dados do recado não especificados.');
        window.location.href = 'mural.php';
    </script>";
}

$conn->close();
?>
