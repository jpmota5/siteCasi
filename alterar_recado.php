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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obter o recado específico
    $sql = "SELECT titulo, mensagem FROM recados WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($titulo, $mensagem);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "<script>
        alert('ID do recado não especificado.');
        window.location.href = 'mural.php';
    </script>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Recado</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("cadastro2.png");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat; 
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; 
        }
        .form-container {
            background-color: rgba(0, 128, 0, 0.7);
            padding: 20px;
            border-radius: 20px;
            width: 50%;
            color: white;
            text-align: center;
        }
        h1 {
            color: white;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], textarea {
            width: calc(100% - 22px); /* Subtrai padding e bordas */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        button {
            background-color: #006400;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2e8b57;
        }
        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #006400;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>

    <a href="mural.php" class="home-button">Mural de Recados</a>

    <div class="form-container">
        <h1>Alterar Recado</h1>
        <form action="processar_alteracao.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>
            
            <label for="mensagem">Conteúdo:</label>
            <textarea name="mensagem" id="mensagem" required><?php echo htmlspecialchars($mensagem); ?></textarea>
            
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>

</body>
</html>
