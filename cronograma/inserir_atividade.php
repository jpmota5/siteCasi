<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'casi');

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Captura os dados do formulário
$horario = $_POST['horario'];
$atividade = $_POST['atividade'];
$criancas = $_POST['criancas']; // Este será um array com os IDs das crianças

// Verifica se o horário já existe no cronograma
$sql_verifica = "SELECT id FROM cronograma WHERE horario = ?";
$stmt = $conn->prepare($sql_verifica);
$stmt->bind_param('s', $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se o horário já existe, obtenha o ID
    $row = $result->fetch_assoc();
    $id_cronograma = $row['id'];

    // Atualiza a atividade no horário correspondente (aqui você pode querer fazer ajustes para mais dias)
    $sql_update = "UPDATE cronograma SET segunda = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $atividade, $id_cronograma);
    $stmt_update->execute();
} else {
    // Se o horário não existir, insere o horário e a atividade no cronograma
    $sql_insert = "INSERT INTO cronograma (horario, segunda) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('ss', $horario, $atividade);
    $stmt_insert->execute();
    $id_cronograma = $stmt_insert->insert_id; // Obtém o ID do cronograma inserido
}

// Vincula as crianças à atividade
$sql_vincula = "INSERT INTO atividades_alunos (id_cronograma, id_aluno) VALUES (?, ?)";
$stmt_vincula = $conn->prepare($sql_vincula);

// Para cada criança selecionada no formulário
foreach ($criancas as $id_aluno) {
    $stmt_vincula->bind_param('ii', $id_cronograma, $id_aluno);
    $stmt_vincula->execute();
}

echo "Atividade cadastrada com sucesso!";

// Fecha os prepared statements de forma segura, verificando se foram inicializados
if (isset($stmt)) {
    $stmt->close();
}
if (isset($stmt_update)) {
    $stmt_update->close();
}
if (isset($stmt_insert)) {
    $stmt_insert->close();
}
if (isset($stmt_vincula)) {
    $stmt_vincula->close();
}

$conn->close();
?>
