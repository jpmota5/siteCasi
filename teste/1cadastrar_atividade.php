<?php
require '1conexao.php';

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $dia_da_semana = $_POST['dia_da_semana'];
    $horario = $_POST['horario'];

    // Preparar e executar a inserção no banco
    $stmt = $conn->prepare("INSERT INTO 1atividades (nome, descricao, dia_da_semana, horario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $descricao, $dia_da_semana, $horario);

    if ($stmt->execute()) {
        // Redirecionar para visualizar cronograma após o sucesso
        header("Location: 1visualizar_cronograma.php");
        exit;
    } else {
        echo "Erro ao salvar a atividade: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Nova Atividade</title>
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

        input, select, textarea, button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus, select:focus, textarea:focus, button:focus {
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

        .form-group {
            display: flex;
            flex-direction: column;
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
        <h1>Cadastrar Nova Atividade</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="dia_da_semana">Dia da Semana:</label>
                <select id="dia_da_semana" name="dia_da_semana" required>
                    <option value="">Selecione o dia</option>
                    <option value="Segunda">Segunda</option>
                    <option value="Terça">Terça</option>
                    <option value="Quarta">Quarta</option>
                    <option value="Quinta">Quinta</option>
                    <option value="Sexta">Sexta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="horario">Horário:</label>
                <input type="time" id="horario" name="horario" required>
            </div>

            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>
