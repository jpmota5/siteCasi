<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Pega o caminho da imagem a ser excluída
    $sql = "SELECT imagem FROM mural WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagem = $row['imagem'];

        // Remove a imagem do servidor
        $caminhoImagem = 'uploads/' . $imagem;
        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        // Exclui o registro do banco de dados
        $sql = "DELETE FROM mural WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Imagem excluída com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao excluir a imagem: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();

// Redireciona para o mural após a exclusão
echo "<meta http-equiv='refresh' content='0;url=mural.php'>";
?>
