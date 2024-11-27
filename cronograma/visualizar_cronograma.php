<?php
$conn = new mysqli('localhost', 'root', '', 'casi');
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Consulta principal para obter o cronograma
$sql = "SELECT * FROM cronograma ORDER BY FIELD(horario, '08:00-09:00', '09:00-10:00', '10:00-11:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00')";
$result = $conn->query($sql);

// Função para obter crianças vinculadas a uma atividade
function getCriançasVinculadas($atividadeId, $conn) {
    $criancasSql = "SELECT c.nome
                    FROM atividades_alunos aa
                    JOIN criancas c ON aa.id_aluno = c.id
                    WHERE aa.id_cronograma = ?";
    $stmt = $conn->prepare($criancasSql);
    $stmt->bind_param("i", $atividadeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $criancas = [];
    while ($row = $result->fetch_assoc()) {
        $criancas[] = $row['nome'];
    }
    return $criancas;
}
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

        .crianças-list {
            display: none;
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
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

        .button-container2 {
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
    </style>
    <script>
        function toggleDetails(id) {
            const detailsElement = document.getElementById(id);
            if (detailsElement.style.display === 'none' || detailsElement.style.display === '') {
                detailsElement.style.display = 'block';
            } else {
                detailsElement.style.display = 'none';
            }
        }
    </script>
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
                <th>Horário</th>
                <th>Segunda-feira</th>
                <th>Terça-feira</th>
                <th>Quarta-feira</th>
                <th>Quinta-feira</th>
                <th>Sexta-feira</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $horario = $row['horario'];
                echo "<tr>";
                echo "<td>{$row['horario']}</td>";

                $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
                foreach ($dias as $i => $dia) {
                    $atividade = htmlspecialchars($row[$dia] ?? '');
                    if ($atividade) {
                        $criancas = getCriançasVinculadas($row['id'], $conn);
                        $criancasList = implode(", ", $criancas);
                        echo "<td>
                                <a href=\"javascript:void(0);\" onclick=\"toggleDetails('details_{$row['id']}_$i')\">$atividade</a>
                                <div id=\"details_{$row['id']}_$i\" class=\"crianças-list\">
                                    <strong>Crianças vinculadas:</strong><br>
                                    $criancasList
                                </div>
                              </td>";
                    } else {
                        echo "<td></td>";
                    }
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma atividade cadastrada</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>

    <div class="button-container2">
        <a href="cronograma.php" class="register-button">Cadastrar Atividade</a>

    </div>

</body>
</html>

<?php
$conn->close();
?>
