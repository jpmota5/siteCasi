<?php
require '1conexao.php';

$query = "
    SELECT 
        a.id AS atividade_id,
        a.nome AS atividade, 
        a.descricao, 
        a.dia_da_semana, 
        a.horario, 
        IFNULL(GROUP_CONCAT(c.nome SEPARATOR ', '), '-') AS criancas
    FROM 1atividades a
    LEFT JOIN 1atividade_crianca ac ON ac.id_atividade = a.id
    LEFT JOIN criancas c ON ac.id_crianca = c.id
    GROUP BY a.id, a.nome, a.descricao, a.dia_da_semana, a.horario
    ORDER BY 
        FIELD(a.dia_da_semana, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'), 
        a.horario
";

$result = $conn->query($query);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronograma de Atividades</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f7fc;
        }

        td {
            background-color: #fff;
            cursor: pointer;
        }

        td:hover {
            background-color: #f1f1f1;
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

        .button-container {
            text-align: center;
            margin: 20px 0;
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

        .register-button {
            background-color: #006400;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .register-button:hover {
            background-color: #2e8b57;
        }

        .actions .btn {
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-right: 10px; /* Espaçamento entre os botões */
            transition: background-color 0.3s, transform 0.2s;
        }

        .actions .btn:last-child {
            margin-right: 0; /* Remove margem do último botão */
        }

        /* Botão "Adicionar Criança" */
        .actions .btn:first-child {
            background-color: #006400; /* Verde */
        }

        .actions .btn:first-child:hover {
            background-color: #2e8b57; /* Verde mais escuro */
        }

        /* Botão "Excluir" */
        .actions .btn:last-child {
            margin-top: 8px;
            background-color: #ff0000; /* Vermelho */
        }

        .actions .btn:last-child:hover {
            background-color: #cc0000; /* Vermelho mais escuro */
        }


    </style>
</head>
<body>
    <div class="button-container">
        <a href="../index.html" class="home-button">Página Inicial</a>
    </div>
    
    <div class="container">
        <h1>Cronograma de Atividades</h1>
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Horário</th>
                    <th>Atividade</th>
                    <th>Descrição</th>
                    <th>Crianças</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['dia_da_semana'] ?></td>
                        <td><?= $row['horario'] ?></td>
                        <td><?= $row['atividade'] ?></td>
                        <td><?= $row['descricao'] ?></td>
                        <td><?= $row['criancas'] ?></td>
                        <td class="actions">
                            <a href="1vincular_crianca.php?id_atividade=<?= $row['atividade_id'] ?>" class="btn">Adicionar Criança</a>
                            <a href="1excluir_atividade.php?id=<?= $row['atividade_id'] ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta atividade?');">Excluir</a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="button-container">
        <a href="1cadastrar_atividade.php" class="register-button">Cadastrar Nova Atividade</a>
    </div>
</body>
</html>
