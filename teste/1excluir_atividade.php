<?php
require '1conexao.php';

// Verificar se o ID foi enviado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Excluir a atividade com base no ID
    $stmt = $conn->prepare("DELETE FROM 1atividades WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirecionar para a página do cronograma após a exclusão
        header("Location: 1visualizar_cronograma.php?mensagem=Atividade excluída com sucesso");
        exit;
    } else {
        echo "Erro ao excluir a atividade: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID inválido ou não fornecido.";
}

$conn->close();
?>
