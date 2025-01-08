<?php
require '1conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_atividade = $_POST['id_atividade'];
    $id_criancas = $_POST['id_crianca']; // Agora um array

    foreach ($id_criancas as $id_crianca) {
        // Verificar se a combinação já existe
        $stmt_check = $conn->prepare("SELECT COUNT(*) FROM 1atividade_crianca WHERE id_atividade = ? AND id_crianca = ?");
        $stmt_check->bind_param("ii", $id_atividade, $id_crianca);
        $stmt_check->execute();
        $stmt_check->bind_result($exists);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($exists > 0) {
            continue;
        }

        $stmt = $conn->prepare("INSERT INTO 1atividade_crianca (id_atividade, id_crianca) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_atividade, $id_crianca);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: 1visualizar_cronograma.php");
    exit;
}

$atividades = $conn->query("SELECT id, nome, descricao, dia_da_semana, horario FROM 1atividades");
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

        select {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        select:focus {
            border-color: #5c6bc0;
            outline: none;
        }

        button {
            padding: 10px 20px;
            background-color: #008000;
            color: white;
            border: none;
            border-radius: 5px;
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
    <div class="container">
        <h1>Vincular Criança a Atividade</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_atividade">Atividade:</label>
                <select id="id_atividade" name="id_atividade" onchange="mostrarDetalhesAtividade()" required>
                    <option value="">Selecione uma atividade</option>
                    <?php while ($atividade = $atividades->fetch_assoc()): ?>
                        <option value="<?= $atividade['id'] ?>" 
                            data-descricao="<?= $atividade['descricao'] ?>" 
                            data-dia="<?= $atividade['dia_da_semana'] ?>" 
                            data-horario="<?= $atividade['horario'] ?>">
                            <?= $atividade['nome'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div id="detalhes_atividade" style="margin-top: 20px;">
                <p><strong>Descrição:</strong> <span id="descricao"></span></p>
                <p><strong>Dia da Semana:</strong> <span id="dia_da_semana"></span></p>
                <p><strong>Horário:</strong> <span id="horario"></span></p>
            </div>

            <div class="form-group">
                <label for="id_crianca">Crianças:</label>
                <select id="id_crianca" name="id_crianca[]" multiple required>
                    <?php while ($crianca = $criancas->fetch_assoc()): ?>
                        <option value="<?= $crianca['id'] ?>"><?= $crianca['nome'] ?></option>
                    <?php endwhile; ?>
                </select>
                <p>Pressione Ctrl para selecionar várias crianças.</p>
            </div>

            <button type="submit">Vincular</button>
        </form>
    </div>

    <script>
        function mostrarDetalhesAtividade() {
            const selectAtividade = document.getElementById('id_atividade');
            const selectedOption = selectAtividade.options[selectAtividade.selectedIndex];

            const descricao = selectedOption.getAttribute('data-descricao') || '';
            const dia = selectedOption.getAttribute('data-dia') || '';
            const horario = selectedOption.getAttribute('data-horario') || '';

            document.getElementById('descricao').textContent = descricao;
            document.getElementById('dia_da_semana').textContent = dia;
            document.getElementById('horario').textContent = horario;
        }
    </script>
</body>
</html>

