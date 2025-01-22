<?php
session_start(); // Inicia a sessão
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

        ul.child-list {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }

        ul.child-list li {
            padding: 12px;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }

        ul.child-list li:hover {
            background-color: #f1f1f1;
        }

        ul.child-list a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        ul.child-list a:hover {
            color: #006400;
        }

        .delete-button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 8px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .delete-button:hover {
            background-color: #cc0000;
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
            text-decoration: none;
        }

        .home-button:hover {
            background-color: #2e8b57;
        }

        .mensagem {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .mensagem.erro {
            background-color: #ffcccc;
            color: #cc0000;
        }

        .mensagem.sucesso {
            background-color: #ccffcc;
            color: #006600;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="../index.html" class="home-button">Página Inicial</a>
    </div>

    <div class="container">
        <h1>Lista de Crianças Cadastradas</h1>

        <!-- Exibe mensagens de sucesso ou erro -->
        <?php
        if (isset($_SESSION['mensagem'])) {
            $tipo = $_SESSION['tipo_mensagem'] ?? 'sucesso';
            echo "<div class='mensagem $tipo'>" . $_SESSION['mensagem'] . "</div>";
            unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); // Limpa a mensagem após exibir
        }
        ?>

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
        
        <a href="cadastro_criancas.html" class="home-button">Cadastrar Nova Criança</a>
    </div>
</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>
