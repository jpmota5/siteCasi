<?php
require '1conexao.php';

// Variáveis iniciais
$id_atividade = $_GET['id_atividade'] ?? null;
$vinculos = [];

// Buscar atividades
$atividades = $conn->query("SELECT id, nome FROM 1atividades");

// Buscar crianças
$criancas = $conn->query("SELECT id, nome FROM criancas");

// Buscar vínculos existentes para a atividade selecionada
if (!empty($id_atividade)) {
    $stmt_vinculos = $conn->prepare("SELECT id_crianca FROM 1atividade_crianca WHERE id_atividade = ?");
    $stmt_vinculos->bind_param("i", $id_atividade);
    $stmt_vinculos->execute();
    $result_vinculos = $stmt_vinculos->get_result();
    while ($row = $result_vinculos->fetch_assoc()) {
        $vinculos[] = $row['id_crianca'];
    }
    $stmt_vinculos->close();
}

// Atualizar crianças na atividade
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id_atividade = $_POST['id_atividade'];
    $criancas_selecionadas = $_POST['criancas'] ?? [];

    // Remover vínculos antigos
    $stmt_remove = $conn->prepare("DELETE FROM 1atividade_crianca WHERE id_atividade = ?");
    $stmt_remove->bind_param("i", $id_atividade);
    $stmt_remove->execute();
    $stmt_remove->close();

    // Adicionar novos vínculos
    $stmt_add = $conn->prepare("INSERT INTO 1atividade_crianca (id_atividade, id_crianca) VALUES (?, ?)");
    foreach ($criancas_selecionadas as $id_crianca) {
        $stmt_add->bind_param("ii", $id_atividade, $id_crianca);
        $stmt_add->execute();
    }
    $stmt_add->close();

    header("Location: 1visualizar_cronograma.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Crianças da Atividade</title>
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
        }

        h1 {
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background-color: #006400;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2e8b57;
        }

        label {
            font-size: 16px;
            margin: 10px 0;
            display: block;
            text-align: left;
        }

        .checkbox-list {
            text-align: left;
            margin-top: 20px;
        }

        .checkbox-item {
            margin-bottom: 10px;
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
        <h1>Editar Crianças da Atividade</h1>

        <!-- Formulário para selecionar atividade -->
        <form method="GET" action="">
            <label for="id_atividade">Selecione a Atividade:</label>
            <select name="id_atividade" id="id_atividade">
                <option value="">-- Escolha uma atividade --</option>
                <?php while ($atividade = $atividades->fetch_assoc()): ?>
                    <option value="<?= $atividade['id'] ?>" <?= $id_atividade == $atividade['id'] ? 'selected' : '' ?>>
                        <?= $atividade['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Carregar</button>
        </form>

        <?php if (!empty($id_atividade)): ?>
            <!-- Formulário para editar crianças vinculadas à atividade -->
            <form method="POST" action="">
                <input type="hidden" name="id_atividade" value="<?= $id_atividade ?>">
                <label>Selecione as Crianças:</label>
                <div class="checkbox-list">
                    <?php while ($crianca = $criancas->fetch_assoc()): ?>
                        <div class="checkbox-item">
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="criancas[]" 
                                    value="<?= $crianca['id'] ?>" 
                                    <?= in_array($crianca['id'], $vinculos) ? 'checked' : '' ?>>
                                <?= $crianca['nome'] ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <button type="submit" name="salvar">Salvar</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
