<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

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
        /* Mesma estilização */
    </style>
</head>
<body>
    <div class="box">
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
                            <?php echo $row['segunda']; ?>
                            <?php
                            $id = $row['id'];
                            $alunos = $conn->query("SELECT nome FROM criancas a JOIN atividades_alunos aa ON a.id = aa.id_aluno WHERE aa.id_cronograma = $id");
                            while ($aluno = $alunos->fetch_assoc()) {
                                echo "<br>- " . $aluno['nome'];
                            }
                            ?>
                        </td>
                        <!-- Repete para outros dias -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
