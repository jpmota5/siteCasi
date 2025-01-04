<?php
require '1conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_atividade = $_POST['id_atividade'];
    $id_crianca = $_POST['id_crianca'];

    // Verificar se a combinação já existe
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM 1atividade_crianca WHERE id_atividade = ? AND id_crianca = ?");
    $stmt_check->bind_param("ii", $id_atividade, $id_crianca);
    $stmt_check->execute();
    $stmt_check->bind_result($exists);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($exists > 0) {
        // Combinação já existe
        echo "<script>alert('Esta criança já está vinculada a esta atividade.'); window.location.href='1visualizar_cronograma.php';</script>";
    } else {
        // Inserir nova combinação
        $stmt = $conn->prepare("INSERT INTO 1atividade_crianca (id_atividade, id_crianca) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_atividade, $id_crianca);
        if ($stmt->execute()) {
            header("Location: 1visualizar_cronograma.php");
            exit;
        } else {
            echo "Erro ao vincular criança: " . $conn->error;
        }
        $stmt->close();
    }
}

$atividades = $conn->query("SELECT id, nome FROM 1atividades");
$criancas = $conn->query("SELECT id, nome FROM criancas");

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular Criança</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-image: url('../cadastro2.png');
            background-position: center center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input, select, button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus, select:focus, button:focus {
            border-color: #5c6bc0;
            outline: none;
        }

        button {
            background-color: #008000;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2e8b57;
        }

        .button-container {
            text-align: center;
        }

        .home-button {
            background-color: #008000;
            border: none;
            padding: 15px;
            font-size: 15px;
            cursor: pointer;
            border-radius: 15px;
            color: white;
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: center;
            text-decoration: none;
        }

        .home-button:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="../index.html" class="home-button">Página Inicial</a>
    </div>

    <div class="container">
        <h1>Vincular Criança a Atividade</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_atividade">Atividade:</label>
                <select id="id_atividade" name="id_atividade" required>
                    <?php while ($atividade = $atividades->fetch_assoc()): ?>
                        <option value="<?= $atividade['id'] ?>"><?= $atividade['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_crianca">Criança:</label>
                <select id="id_crianca" name="id_crianca" required>
                    <?php while ($crianca = $criancas->fetch_assoc()): ?>
                        <option value="<?= $crianca['id'] ?>"><?= $crianca['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit">Vincular</button>
        </form>
    </div>
</body>
</html>
