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

// Obtém o ID da criança a partir do parâmetro da URL
$id = $_GET['id'] ?? 0;

// Consulta para obter os detalhes da criança
$sql = "SELECT * FROM criancas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$child = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha da Criança</title>
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
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Adicionado para alinhar os botões corretamente */
        }
        h1 {
            text-align: center; /* Centraliza o título */
            margin-bottom: 20px;
        }
        .detail {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .detail label {
            font-weight: bold;
        }
        .back-button, .edit-button {
            background-color: #008000;
            border: none;
            padding: 15px;
            font-size: 15px;
            cursor: pointer;
            border-radius: 15px;
            color: white;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
        .back-button:hover, .edit-button:hover {
            background-color: #2e8b57;
        }
        .back-button {
            position: absolute; /* Posiciona o botão de volta no canto superior direito */
            top: 20px;
            right: 20px;
        }
        .edit-button-wrapper {
            text-align: center; /* Centraliza o botão dentro da div */
            margin-top: 20px; /* Adiciona margem acima do botão */
        }
    </style>
</head>
<body>
    <a href="visualizar_criancas.php" class="back-button">Voltar à Lista</a>
    <div class="container">
        <h1>Ficha da Criança</h1>
        
        <?php if ($child): ?>
            <div class="detail">
                <label>Nome:</label>
                <span><?php echo htmlspecialchars($child['nome']); ?></span>
            </div>
            <div class="detail">
                <label>Endereço:</label>
                <span><?php echo htmlspecialchars($child['endereco']); ?></span>
            </div>
            <div class="detail">
                <label>Responsável:</label>
                <span><?php echo htmlspecialchars($child['responsavel']); ?></span>
            </div>
            <div class="detail">
                <label>Contato 1:</label>
                <span><?php echo htmlspecialchars($child['contato1']); ?></span>
            </div>
            <div class="detail">
                <label>Contato 2:</label>
                <span><?php echo htmlspecialchars($child['contato2']); ?></span>
            </div>
            <div class="detail">
                <label>Turno:</label>
                <span><?php echo htmlspecialchars($child['turno']); ?></span>
            </div>
            <div class="detail">
                <label>Gênero:</label>
                <span><?php echo htmlspecialchars($child['dia']); ?></span>
            </div>
            <div class="detail">
                <label>Data de Nascimento:</label>
                <span><?php echo htmlspecialchars($child['data_nascimento']); ?></span>
            </div>
            
            <!-- Centraliza o botão para editar os dados -->
            <div class="edit-button-wrapper">
                <a href="editar_crianca.php?id=<?php echo htmlspecialchars($child['id']); ?>" class="edit-button">Alterar Dados</a>
            </div>
        <?php else: ?>
            <p>Criança não encontrada.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>