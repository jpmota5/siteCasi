<?php
session_start(); // Inicia a sessão
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

    // Verifica se a criança está vinculada a alguma atividade
    $sql_check = "SELECT COUNT(*) AS total FROM 1atividade_crianca WHERE id_crianca = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['total'] > 0) {
        $_SESSION['mensagem'] = "Não é possível excluir a criança, pois ela está vinculada a uma ou mais atividades.";
        $_SESSION['tipo_mensagem'] = "erro";
    } else {
        // Prepara e executa a consulta para deletar a criança
        $sql = "DELETE FROM criancas WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "Criança excluída com sucesso.";
            $_SESSION['tipo_mensagem'] = "sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro ao excluir criança: " . $conn->error;
            $_SESSION['tipo_mensagem'] = "erro";
        }

        $stmt->close();
    }

    $stmt_check->close();
}

// Fecha a conexão
$conn->close();

// Redireciona de volta para a página de visualização
header("Location: visualizar_criancas.php");
exit;
?>
