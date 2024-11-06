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

// Consulta para obter os nomes das crianças
$sql = "SELECT id, nome FROM criancas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Crianças</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../cadastro2.png');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .child-list {
            list-style-type: none;
            padding: 0;
            text-align: justify;
            text-justify: inter-word;
        }
        .child-list li {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .child-list a {
            text-decoration: none;
            color: #0066cc;
        }
        .child-list a:hover {
            text-decoration: underline;
        }
        .delete-button {
            background-color: #ff0000;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
        .view-button {
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
        .view-button:hover {
            background-color: #2e8b57;
        }
        .home-button {
            background-color: #006400;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>
    <a href="../index.html" class="view-button">Página Inicial</a>
    <div class="container">
        <h1>Lista de Crianças Cadastradas</h1>
        <ul class="child-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<a href='ficha_crianca.php?id=" . $row["id"] . "'>" . $row["nome"] . "</a>";
                    // Adicionando confirmação na exclusão
                    echo "<form action='excluir_crianca.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja excluir esta criança?\");'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='submit' class='delete-button' value='Excluir'>";
                    echo "</form>";
                    echo "</li>";
                }
            } else {
                echo "<li>Nenhuma criança cadastrada.</li>";
            }
            ?>
        </ul>
        
        <a href="cadastro_criancas.html" class="home-button">Cadastrar</a>
    </div>
</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>
