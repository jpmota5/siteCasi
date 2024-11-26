<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'casi');
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$horario = $_POST['horario'] ?? null;
$atividade = $_POST['atividade'] ?? null;
$dia = $_POST['dia'] ?? null;
$criancas = $_POST['criancas'] ?? [];

if (empty($horario) || empty($atividade) || empty($dia) || empty($criancas)) {
    die("Erro: Todos os campos são obrigatórios.");
}

// Verifica se o horário já existe
$sql_verifica = "SELECT id FROM cronograma WHERE horario = ?";
$stmt = $conn->prepare($sql_verifica);
$stmt->bind_param('s', $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Atualiza a atividade na célula correspondente ao dia
    $row = $result->fetch_assoc();
    $id_cronograma = $row['id'];

    // Atualiza a célula do dia correspondente
    $sql_update = "UPDATE cronograma SET $dia = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $atividade, $id_cronograma);
    $stmt_update->execute();
} else {
    // Caso o horário não exista, insere um novo horário
    $sql_insert = "INSERT INTO cronograma (horario, $dia) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('ss', $horario, $atividade);
    $stmt_insert->execute();
    $id_cronograma = $stmt_insert->insert_id;
}

// Vincula as crianças à atividade
$sql_vincula = "INSERT INTO atividades_alunos (id_cronograma, id_aluno) VALUES (?, ?)";
$stmt_vincula = $conn->prepare($sql_vincula);
foreach ($criancas as $id_aluno) {
    $stmt_vincula->bind_param('ii', $id_cronograma, $id_aluno);
    $stmt_vincula->execute();
}

// Fecha a conexão
$conn->close();

// Exibe a notificação de sucesso e redireciona para visualizar_cronograma.php
echo "<script>
        alert('Atividade cadastrada com sucesso!');
        window.location.href = 'visualizar_cronograma.php';
      </script>";
exit;
?>
