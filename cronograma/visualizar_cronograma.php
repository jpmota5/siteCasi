<?php
$conn = new mysqli('localhost', 'root', '', 'casi');
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$sql = "SELECT * FROM cronograma";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronograma Semanal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .toggle-btn {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }

        .details {
            display: none;
            text-align: left;
            margin-top: 10px;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 5px;
        }

        .details strong {
            color: #333;
        }
    </style>
    <script>
        function toggleDetails(id) {
            const details = document.getElementById(`details-${id}`);
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h1>Cronograma Semanal</h1>
    <table>
        <thead>
            <tr>
                <th>Horário</th>
                <th>Segunda</th>
                <th>Terça</th>
                <th>Quarta</th>
                <th>Quinta</th>
                <th>Sexta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['horario']; ?></td>
                    <td>
                        <?php 
                        if (!empty($row['segunda'])): 
                            $id = $row['id']; // Aqui definimos o ID da linha
                        ?>
                            <span class="toggle-btn" onclick="toggleDetails('<?php echo $id; ?>')">
                                <?php echo $row['segunda']; ?>
                            </span>
                            <div id="details-<?php echo $id; ?>" class="details">
                                <strong>Crianças:</strong>
                                <?php
                                // Usando o ID para fazer a consulta corretamente
                                $alunos = $conn->query("
                                    SELECT nome 
                                    FROM criancas a 
                                    JOIN atividades_alunos aa ON a.id = aa.id_aluno 
                                    WHERE aa.id_cronograma = '$id'
                                ");
                                
                                if ($alunos->num_rows > 0) {
                                    while ($aluno = $alunos->fetch_assoc()) {
                                        echo "<br>- " . $aluno['nome'];
                                    }
                                } else {
                                    echo "<br>Nenhuma criança cadastrada.";
                                }
                                ?>
                            </div>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row['terca'])): ?>
                            <?php $id = $row['id']; // Definindo o ID novamente ?>
                            <span class="toggle-btn" onclick="toggleDetails('<?php echo $id; ?>')">
                                <?php echo $row['terca']; ?>
                            </span>
                            <div id="details-<?php echo $id; ?>" class="details">
                                <strong>Crianças:</strong>
                                <?php
                                // Usando o ID para fazer a consulta corretamente
                                $alunos = $conn->query("
                                    SELECT nome 
                                    FROM criancas a 
                                    JOIN atividades_alunos aa ON a.id = aa.id_aluno 
                                    WHERE aa.id_cronograma = '$id'
                                ");
                                if ($alunos->num_rows > 0) {
                                    while ($aluno = $alunos->fetch_assoc()) {
                                        echo "<br>- " . $aluno['nome'];
                                    }
                                } else {
                                    echo "<br>Nenhuma criança cadastrada.";
                                }
                                ?>
                            </div>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['quarta'] ?: '-'; ?></td>
                    <td><?php echo $row['quinta'] ?: '-'; ?></td>
                    <td><?php echo $row['sexta'] ?: '-'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
