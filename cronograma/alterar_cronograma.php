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

// Obtém o id da URL
$id = $_GET['id'] ?? 0;
if (!is_numeric($id)) {
    die("ID inválido.");
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $horario = $_POST['horario'];
    $segunda = $_POST['segunda'];
    $terca = $_POST['terca'];
    $quarta = $_POST['quarta'];
    $quinta = $_POST['quinta'];
    $sexta = $_POST['sexta'];
    $id = $_POST['id'];

    // Prepara a consulta SQL para atualização
    $sql = "UPDATE cronograma SET horario=?, segunda=?, terca=?, quarta=?, quinta=?, sexta=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $horario, $segunda, $terca, $quarta, $quinta, $sexta, $id);

    if ($stmt->execute()) {
        // Se a atualização foi bem-sucedida, exibe um pop-up e redireciona
        echo "<script>
                alert('Dados atualizados com sucesso!');
                window.location.href = 'visualizar_cronograma.php';
              </script>";
        exit; // Adiciona um exit para evitar execução adicional após o redirecionamento
    } else {
        echo "<p>Erro: " . $stmt->error . "</p>";
    }
}

// Consulta para obter os dados do cronograma
$sql = "SELECT * FROM cronograma WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cronograma = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cronograma</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("../cadastro2.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; 
            width: 100vw;
            height: 100vh;
            overflow: hidden; 
        }
        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 128, 0, 0.7);
            padding: 20px;
            border-radius: 20px;
            width: 50%;
            color: white;
        }
        h1 {
            text-align: center;
            color: white;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: calc(100% - 20px);
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .top-right-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: #008000;
            padding: 10px 20px;
            border-radius: 10px;
        }
        .top-right-button:hover {
            background-color: #2e8b57;
        }
        .action-button {
            background-color: #008000;
            width: 40%;
            border: none;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 15px;
            color: white;
            margin: 0 auto;
            display: block;
        }
        .action-button:hover {
            background-color:#2e8b57;
            cursor: pointer;
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <a href="../index.html" class="top-right-button">Página inicial</a>

    <div class="box">
        <h1>Alterar Cronograma</h1>
        <?php if ($cronograma): ?>
            <form action="alterar_cronograma.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($cronograma['id']); ?>">

                <label for="horario">Horário:</label>
                <input type="text" id="horario" name="horario" value="<?php echo htmlspecialchars($cronograma['horario']); ?>" required>

                <label for="segunda">Segunda-Feira:</label>
                <input type="text" id="segunda" name="segunda" value="<?php echo htmlspecialchars($cronograma['segunda']); ?>" required>

                <label for="terca">Terça-Feira:</label>
                <input type="text" id="terca" name="terca" value="<?php echo htmlspecialchars($cronograma['terca']); ?>" required>

                <label for="quarta">Quarta-Feira:</label>
                <input type="text" id="quarta" name="quarta" value="<?php echo htmlspecialchars($cronograma['quarta']); ?>" required>

                <label for="quinta">Quinta-Feira:</label>
                <input type="text" id="quinta" name="quinta" value="<?php echo htmlspecialchars($cronograma['quinta']); ?>" required>

                <label for="sexta">Sexta-Feira:</label>
                <input type="text" id="sexta" name="sexta" value="<?php echo htmlspecialchars($cronograma['sexta']); ?>" required>

                <button type="submit" class="action-button">Atualizar</button>
            </form>
        <?php else: ?>
            <p>Dados do cronograma não encontrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>