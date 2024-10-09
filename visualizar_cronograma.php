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

// Consulta para obter todos os dados do cronograma
$sql = "SELECT * FROM cronograma";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronograma Semanal</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("cadastro2.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; 
            width: 100vw;
            height: 100vh;
            overflow: hidden; 
        }
        .box {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 128, 0, 0.7);
            padding: 12px;
            border-radius: 20px;
            width: 50%;
            color: white;
        }
        h1 {
            text-align: center;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
            color: white;
        }
        th {
            background-color: rgba(0, 128, 0, 0.7);
        }
        header {
            text-align: center;
            margin-top: 5px;
        }
        header img {
            max-width: 70px;
        }
        header h2 {
            font-size: 20px;
            color: black;
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .action-buttons a {
            text-decoration: none;
            color: white;
            background-color: #006400;
            padding: 10px 20px;
            border-radius: 10px;
            margin: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .action-buttons a:hover {
            background-color: #2e8b57;
        }
        .top-right-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: white;
            background-color: #006400;
            padding: 10px 20px;
            border-radius: 10px;
            transition: background-color 0.3s;
        }
        .top-right-button:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>

    <header>
        <img src="img/logoprefeitura.png" alt="Logo">
        <h2>CASI - Centro de Atendimento Sócio-Infantil</h2>
    </header>

    <a href="index.html" class="top-right-button">Página inicial</a>

    <div class="box">
        <h1>Cronograma Semanal</h1>
        <table>
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Segunda-Feira</th>
                    <th>Terça-Feira</th>
                    <th>Quarta-Feira</th>
                    <th>Quinta-Feira</th>
                    <th>Sexta-Feira</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['horario']); ?></td>
                            <td><?php echo htmlspecialchars($row['segunda']); ?></td>
                            <td><?php echo htmlspecialchars($row['terca']); ?></td>
                            <td><?php echo htmlspecialchars($row['quarta']); ?></td>
                            <td><?php echo htmlspecialchars($row['quinta']); ?></td>
                            <td><?php echo htmlspecialchars($row['sexta']); ?></td>
                            <td>
                                <a href="alterar_cronograma.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="action-buttons">Alterar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhuma atividade cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="cronograma.html">Cadastrar Atividade</a>
        </div>
    </div>

</body>
</html>

<?php

$conn->close();
?>
