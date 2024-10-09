<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para pegar as imagens e descrições
$sql = "SELECT id, imagem, descricao FROM mural";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Imagens</title>
    <style>
        body {
            padding: 30px;
            font-family: Arial, sans-serif;
            background-image: url("cadastro2.png");
            display: flex;
            background-size: cover;
            background-position: center;
            align-items: center;
            flex-direction: column;
            background-repeat: no-repeat;
        }
        .mural {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 80%;
        }
        .mural-item {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .mural-item img {
            max-width: 100%;
            border-radius: 10px;
        }
        .mural-item p {
            margin-top: 10px;
        }
        .mural-item button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .mural-item button:hover {
            background-color: #cc0000;
        }
        .add-button {
            text-decoration: none;
            color: white;
            background-color: #006400;
            padding: 10px 20px;
            border-radius: 10px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .add-button:hover {
            background-color: #2e8b57;
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
    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir esta imagem?")) {
                window.location.href = 'excluir_imagem.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <header>
        <img src="img/logoprefeitura.png" alt="Logo">
        <h2>CASI - Centro de Atendimento Sócio-Infantil</h2>
    </header>
    <!-- Botão de Página Inicial -->
    <a href="index.html" class="home-button">Página Inicial</a>
<br> <br> 

    <div class="mural">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='mural-item'>";
                echo "<img src='uploads/" . htmlspecialchars($row['imagem']) . "' alt='Imagem do mural'>";
                echo "<p>" . htmlspecialchars($row['descricao']) . "</p>";
                echo "<button onclick='confirmarExclusao(" . $row['id'] . ")'>Excluir</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhuma imagem disponível.</p>";
        }
        ?>
    </div>

    <!-- Botão para adicionar uma nova imagem -->
    <a href="upload_imagem.php" class="add-button">Adicionar Nova Imagem</a>

</body>
</html>

<?php
$conn->close();
?>
